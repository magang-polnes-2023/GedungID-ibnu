<?php

namespace App\Http\Controllers;

use App\Models\gedung;
use Illuminate\Http\Request;

class GedungController extends Controller
{
    public function show()
    {
        $gedungs = gedung::all();
        

        return view('Gedung.gedung', compact('gedungs'));
    }
    

    public function index()
    {
        $gedungs = gedung::all();


        return view('home', compact('gedungs'));
    }
}
