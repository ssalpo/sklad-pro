<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Nomenclature;
use Illuminate\Http\Request;

class AutocompleteController extends Controller
{
    public function nomenclatures()
    {
        return Nomenclature::when(
            request('q'),
            static fn($q, $v) => $q->where('name', 'like', '%' . $v . '%')
        )->get()->transform(fn($m) => [
            'value' => $m->id,
            'text' => $m->name
        ]);
    }

    public function clients()
    {
        return Client::when(
            request('q'),
            static fn($q, $v) => $q->where('name', 'like', '%' . $v . '$')
        )->get()->transform(fn($m) => [
            'value' => $m->id,
            'text' => $m->name
        ]);
    }
}
