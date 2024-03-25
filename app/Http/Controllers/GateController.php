<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Mengambil user yang sedang login
        $user = Auth::user();

        // Mengambil data role dari user
        $roles = $user->roles;

        // Mengembalikan response dengan data user dan roles
        // return response()->json([
        //     'user' => $user,
        //     // 'roles' => $roles,
        // ]);

        return view('dashboard-menu.index', [
            'user' => $user,
        ]);
    }

    // setRole
    public function setRole(Request $request)
    {
        // Mengambil user yang sedang login
        $user = Auth::user();

        // cek apakah request role sama dengan yang dimiliki data role user maka set session selected dengan role yang dipilih
        if ($user->roles->contains($request->role)) {
            // Set session selected_role dengan role yang dipilih
            $request->session()->put('selected_role', $user->roles->find($request->role)->name);

            // Mengembalikan respons OK
            return response()->json(['message' => 'Session role berhasil diatur'], 200);
        } else {
            // Jika role yang dipilih tidak dimiliki user, kirim respons error
            return response()->json(['message' => 'Role tidak valid'], 403);
        }
    }
}
