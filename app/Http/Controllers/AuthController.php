<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $login = $request->input('login');
        $password = $request->input('password');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $login,
            'password' => $password,
        ];

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Username/email atau password salah.'
            ], 401);
        }

        $user = auth()->user();

        // Cek apakah user adalah pegawai atau mahasiswa
        $relationData = null;
        $type = null;

        if ($user->pegawai) {
            $type = 'pegawai';
            $relationData = $user->pegawai;
        } elseif ($user->mahasiswa) {
            $type = 'mahasiswa';
            $relationData = $user->mahasiswa;
        }

        // Ambil role (jika perlu)
        $roles = $user->roles->pluck('name');

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'username' => $user->username,
                'type' => $type,
                'relation' => $relationData,
                'roles' => $roles,
            ],
        ]);
    }
}
