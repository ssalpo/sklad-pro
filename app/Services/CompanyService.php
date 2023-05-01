<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class CompanyService
{
    public function store(array $data)
    {
        $data = $this->uploadLogo($data);

        return Company::create($data);
    }

    public function update(int $id, array $data)
    {
        $company = Company::my()->findOrFail($id);

        $data = $this->uploadLogo($data, $company);

        $company->update($data);

        return $company;
    }

    private function uploadLogo(array $data, ?Company $company = null)
    {
        /** @var UploadedFile $logo */
        if ($logo = Arr::get($data, 'logo')) {
            if ($company?->logo) {
                Storage::disk('public')->delete($company->logo ?? '');
            }

            $data['logo'] = $logo?->store('logos', 'public');
        } else {
            $data = Arr::except($data, 'logo');
        }

        return $data;
    }
}
