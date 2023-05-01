<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function index()
    {
        $companies = Company::my()->get();

        return inertia('QrCodes/Index', compact('companies'));
    }
}
