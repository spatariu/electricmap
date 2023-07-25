<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class Station extends Model
{
    use HasFactory;
    public $timestamps = false;
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function getChargingStations(Request $request)
    {
        try {
            // Validation and other code as before...

            // Get all descendant company IDs for the specified company_id (including itself)
            $companyIds = $this->getDescendantCompanyIds($companyId);

            // Get all stations associated with the descendant company IDs
            $stations = Station::whereIn('company_id', $companyIds)->get();

            // Calculate the distance and filter stations as before...

            return response()->json($result, 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    protected function getDescendantCompanyIds($companyId)
    {
        $descendantCompanyIds = [$companyId];

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
}