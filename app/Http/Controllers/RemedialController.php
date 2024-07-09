<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RemedialController extends Controller
{
    public function index()
    {
        // echo session('selected_filter');
        if (session('selected_role') == 'Mahasiswa') {
            return redirect()->route('remedial.mahasiswa');
        } elseif (session('selected_role') == 'Admin' || session('selected_role') == 'Admin Fakultas') {
            return view('remedial.dashboard');
        } else {
            return redirect()->route('login');
        }
        return view('remedial.mahasiswa.dashboard');
    }
}
