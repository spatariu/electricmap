<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesSeeder extends Seeder
{
    public function run()
    {
        $companies = [
            [
                'id' => 1,
                'name' => 'Company A',
                'parent_company_id' => null,
            ],
            [
                'id' => 2,
                'name' => 'Company B',
                'parent_company_id' => 1,
            ],
            [
                'id' => 3,
                'name' => 'Company C',
                'parent_company_id' => 1,
            ],
            [
                'id' => 4,
                'name' => 'Company D',
                'parent_company_id' => null,
            ],
            [
                'id' => 5,
                'name' => 'Company E',
                'parent_company_id' => 2,
            ],
        ];

        DB::table('companies')->insert($companies);
    }
}