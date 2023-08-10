<?php

namespace App\Http\Controllers;

use App\Models\fasilitas;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    public function show()
    {
        $fasilitas = fasilitas::all();

        return view('Fasilitas.fasilitas', compact('fasilitas'));
    }
}
