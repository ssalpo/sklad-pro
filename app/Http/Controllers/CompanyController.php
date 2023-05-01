<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Services\CompanyService;
use App\Services\Toast;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct(
        public CompanyService $companyService
    )
    {
    }

    public function index()
    {
        $companies = Company::my()->get();

        return inertia('Companies/Index', compact('companies'));
    }

    public function create()
    {
        return inertia('Companies/Edit');
    }

    public function store(CompanyRequest $request)
    {
        $this->companyService->store($request->validated() + ['logo' => $request->file('logo')]);

        Toast::success('Новая компания успешно добавлена.');

        return to_route('companies.index');
    }

    public function edit(int $id)
    {
        $company = Company::my()->findOrFail($id);

        return inertia('Companies/Edit', compact('company'));
    }

    public function update(CompanyRequest $request, int $id)
    {
        $company = $this->companyService->update($id, $request->validated() + ['logo' => $request->file('logo')]);

        Toast::success(sprintf('Данные компании "%s" обновлены.', $company->name));

        return to_route('companies.index');
    }
}
