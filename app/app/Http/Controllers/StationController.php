<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Validator};
use Illuminate\Validation\ValidationException;

class StationController extends Controller
{
    public function index()
    {
        return Station::all();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'company_id' => 'required|exists:companies,id',
            'address' => 'nullable|string',
        ]);

        return Station::create($request->all());
    }

    public function show(Station $station)
    {
        return $station;
    }

    public function update(Request $request, Station $station)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'company_id' => 'required|exists:companies,id',
            'address' => 'nullable|string',
        ]);

        $station->update($request->all());

        return $station;
    }

    public function destroy(Station $station)
    {
        $station->delete();

        return response()->json(['message' => 'Station deleted successfully']);
    }


    public function getChargingStations(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'radius' => 'required|numeric',
                'company_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $radius = (int) $request->radius;
            $companyId = $request->company_id;

            // Get all descendant company IDs for the specified company_id (including itself)
            $companyIds = $this->getDescendantCompanyIds($companyId);

            // Get all stations associated with the descendant company IDs
            $stations = Station::whereIn('company_id', $companyIds)->get();

            $result = [];
            foreach ($stations as $station) {
                $distance = $this->vincentyGreatCircleDistance(
                    $latitude,
                    $longitude,
                    $station->latitude,
                    $station->longitude
                );

                if ($distance <= $radius) {
                    $key = $station->latitude . '|' . $station->longitude;

                    if (!isset($groupedStations[$key])) {
                        $groupedStations[$key] = [
                            'location' => $key,
                            'stations' => [],
                        ];
                    }

                    $groupedStations[$key]['stations'][] = [
                        'id' => $station->id,
                        'name' => $station->name,
                        'latitude' => $station->latitude,
                        'longitude' => $station->longitude,
                        'distance' => round($distance, 2),
                    ];
                }
            }

            // Sort the stations within each group by distance in ascending order
            foreach ($groupedStations as &$group) {
                usort($group['stations'], fn ($a, $b) => $a['distance'] <=> $b['distance']);
            }

            // Convert the associative array to a numerically indexed array for the response
            $result = array_values($groupedStations);


            return response()->json($result, 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    protected function getDescendantCompanyIds($companyId)
    {
        $descendantCompanyIds = [(int) $companyId];

        $this->getDescendantCompanyIdsRecursive($companyId, $descendantCompanyIds);

        return $descendantCompanyIds;
    }

    protected function getDescendantCompanyIdsRecursive($companyId, &$descendantCompanyIds)
    {
        $childrenIds = DB::table('companies')->where('parent_company_id', $companyId)->pluck('id')->toArray();

        foreach ($childrenIds as $childId) {
            $descendantCompanyIds[] = $childId;
            $this->getDescendantCompanyIdsRecursive($childId, $descendantCompanyIds);
        }
    }

    protected function vincentyGreatCircleDistance(
        $latitudeFrom,
        $longitudeFrom,
        $latitudeTo,
        $longitudeTo,
        $earthRadius = 6371
    ) {
        // Convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
            pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);
        return $angle * $earthRadius;
    }

}