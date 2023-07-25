<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Station;


class StationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stations = [
            [
                'name' => 'Arad 1',
                'latitude' => 46.18,
                'longitude' => 21.31,
                'company_id' => 1,
                'address' => 'Address 1',
            ],
            [
                'name' => 'Arad 2',
                'latitude' => 46.18,
                'longitude' => 21.31,
                'company_id' => 1,
                'address' => 'Address 1',
            ],
            [
                'name' => 'Arad 3',
                'latitude' => 46.13,
                'longitude' => 21.32,
                'company_id' => 2,
                'address' => 'Address 2',
            ],
            [
                'name' => 'Arad 4',
                'latitude' => 46.13,
                'longitude' => 21.32,
                'company_id' => 5,
                'address' => 'Address 2',
            ],
            [
                'name' => 'Timisoara 1',
                'latitude' => 45.75,
                'longitude' => 21.25,
                'company_id' => 4,
                'address' => 'Address 3',
            ],
            [
                'name' => 'Timisoara 2',
                'latitude' => 45.75,
                'longitude' => 21.25,
                'company_id' => 5,
                'address' => 'Address 3',
            ],
        ];

        foreach ($stations as $stationData) {
            Station::create($stationData);
        }
        Station::factory()->count(5)->create();
    }
}