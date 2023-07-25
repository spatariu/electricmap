<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        return Company::all();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'parent_company_id' => 'nullable|exists:companies,id',
        ]);

        return Company::create($request->all());
    }

    public function show(Company $company)
    {
        return $company;
    }

    public function update(Request $request, Company $company)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'parent_company_id' => 'nullable|exists:companies,id',
        ]);

        $company->update($request->all());

        return $company;
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return response()->json(['message' => 'Company deleted successfully']);
    }
}