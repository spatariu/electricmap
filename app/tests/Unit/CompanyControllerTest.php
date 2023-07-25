<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Company;


class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        // Create sample companies in the database using the factory
        Company::factory()->count(5)->create();

        // Send a GET request to the index endpoint
        $response = $this->get('/companies');

        // Assert that the response has a successful status code
        $response->assertStatus(200);

        // Assert that the response contains the list of companies from the database
        $companies = Company::all();
        $response->assertJson($companies->toArray());
    }

    public function testStore()
    {
        // Send a POST request with valid company data
        $data = [
            'name' => 'Test Company',
            'parent_company_id' => null,
        ];

        $response = $this->post('/companies', $data);

        // Assert that the response has a successful status code
        $response->assertStatus(201);

        // Assert that the company was stored in the database
        $this->assertDatabaseHas('companies', $data);
    }

    public function testShow()
    {
        // Create a sample company in the database using the factory
        $company = Company::factory()->create();

        // Send a GET request to the show endpoint
        $response = $this->get('/companies/' . $company->id);

        // Assert that the response has a successful status code
        $response->assertStatus(200);

        // Assert that the response contains the correct company data
        $response->assertJson($company->toArray());
    }

    public function testUpdate()
    {
        // Create a sample company in the database using the factory
        $company = Company::factory()->create();

        // Send a PUT request with updated company data
        $updatedData = [
            'name' => 'Updated Company Name',
            'parent_company_id' => null,
        ];

        $response = $this->put('/companies/' . $company->id, $updatedData);

        // Assert that the response has a successful status code
        $response->assertStatus(200);

        // Assert that the company was updated in the database
        $this->assertDatabaseHas('companies', $updatedData);
    }

    public function testDestroy()
    {
        // Create a sample company in the database using the factory
        $company = Company::factory()->create();

        // Send a DELETE request to the destroy endpoint
        $response = $this->delete('/companies/' . $company->id);

        // Assert that the response has a successful status code
        $response->assertStatus(200);

        // Assert that the company was deleted from the database
        $this->assertDeleted($company);
    }
}