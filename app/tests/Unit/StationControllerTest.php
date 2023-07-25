<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{Station, Company};


class StationControllerTest extends TestCase
{
    use RefreshDatabase;

    private $token = '1|7egv6vSKQT7JRQjwk0yPn6yUTOjsiMA6tS9GgEfz';

    protected function setUp(): void
    {
        parent::setUp();

    }

    public function testIndex()
    {
        // Send a GET request to the index endpoint
        $response = $this->get('/stations', ['Authorization' => 'Bearer ' . $this->token]);

        // Assert that the response has a successful status code
        $response->assertStatus(200);

        // Assert that the response contains the list of stations from the database
        $stations = Station::all();
        $response->assertJson($stations->toArray());
    }

    public function testStore()
    {
        // Send a POST request with valid station data
        $response = $this->post('/stations', [
            'name' => 'Test Station',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'company_id' => 1,
            'address' => 'Test Address',
        ]);

        // Assert that the response has a successful status code
        $response->assertStatus(201);

        // Assert that the station was stored in the database
        $this->assertDatabaseHas('stations', [
            'name' => 'Test Station',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'company_id' => 1,
            'address' => 'Test Address',
        ]);
    }

    public function testShow()
    {
        // Create a sample station
        $station = Station::factory()->create();

        // Send a GET request to the show endpoint with the station ID
        $response = $this->get("/stations/{$station->id}");

        // Assert that the response has a successful status code
        $response->assertStatus(200);

        // Assert that the response contains the correct station data
        $response->assertJson($station->toArray());
    }

    public function testUpdate()
    {
        // Create a sample station
        $station = Station::factory()->create();

        // Send a PUT request with updated station data
        $response = $this->put("/stations/{$station->id}", [
            'name' => 'Updated Station',
            'latitude' => 42.3601,
            'longitude' => -71.0589,
            'company_id' => 2,
            'address' => 'Updated Address',
        ]);

        // Assert that the response has a successful status code
        $response->assertStatus(200);

        // Assert that the station was updated in the database
        $this->assertDatabaseHas('stations', [
            'id' => $station->id,
            'name' => 'Updated Station',
            'latitude' => 42.3601,
            'longitude' => -71.0589,
            'company_id' => 2,
            'address' => 'Updated Address',
        ]);
    }

    public function testDestroy()
    {
        // Create a sample station
        $station = Station::factory()->create();

        // Send a DELETE request to the destroy endpoint with the station ID
        $response = $this->delete("/stations/{$station->id}");

        // Assert that the response has a successful status code
        $response->assertStatus(200);

        // Assert that the station was deleted from the database
        $this->assertDeleted('stations', ['id' => $station->id]);
    }

    public function testGetChargingStations()
    {
        // Create sample companies and stations
        $company1 = Company::factory()->create();
        $company2 = Company::factory()->create();

        $station1 = Station::factory()->create([
            'name' => 'Station 1',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'company_id' => $company1->id,
        ]);

        $station2 = Station::factory()->create([
            'name' => 'Station 2',
            'latitude' => 34.0522,
            'longitude' => -118.2437,
            'company_id' => $company2->id,
        ]);

        // Send a GET request to the getChargingStations endpoint with valid parameters
        $response = $this->get('/charging-stations', [
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'radius' => 2000,
            'company_id' => $company1->id,
        ]);

        // Assert that the response has a successful status code
        $response->assertStatus(200);
    }
}