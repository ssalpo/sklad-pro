<?php

namespace App\Http\Controllers;

class PwaController extends Controller
{
    public function manifest()
    {
        return view('manifest');
    }
}
