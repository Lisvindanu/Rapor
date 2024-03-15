<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function verify(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Authentication passed...
            return redirect()->intended('/gate');
        }

        // Coba autentikasi berdasarkan username
        $username = $request->input('email');
        $user = User::where('username', $username)->first();

        if ($user && Auth::attempt(['email' => $user->email, 'password' => $request->input('password')])) {
            $request->session()->regenerate();
            // Authentication passed...
            return redirect()->intended('/gate');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ]);
    }

    function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    function ApiVerify(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Jika validasi gagal, kirim respons dengan pesan error
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Coba melakukan autentikasi
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Jika autentikasi berhasil, buat token untuk pengguna
            $user = Auth::user();
            $token = $user->createToken('Personal Access Token')->accessToken;

            // Kirim respons dengan token bearer
            return response()->json(['token' => $token], 200);
        } else {
            // Jika autentikasi gagal, kirim respons dengan pesan error
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
