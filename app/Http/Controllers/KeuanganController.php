<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    /**
     * Display the main keuangan dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO: Implement proper data fetching
        // For now, just return basic view

        return view('keuangan.index');
    }
}
