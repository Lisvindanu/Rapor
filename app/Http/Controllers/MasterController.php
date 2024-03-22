<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modul;
use App\Models\Role;

class MasterController extends Controller
{
    // dashboard
    public function index()
    {
        return view('master.dashboard');
    }

    // modul
    public function modul()
    {
        // get data modul
        $moduls = Modul::all();
        return view('master.modul.index', [
            'moduls' => $moduls
        ]);
    }

    public function createModul()
    {
        $mode = 'tambah';

        return view('master.modul.create', [
            'mode' => $mode
        ]);
    }

    public function storeModul(Request $request)
    {
        try {
            // Validasi data yang dikirim
            $validatedData = $request->validate([
                'nama_modul' => 'required|string|max:255',
                'tautan' => 'required|string|max:255',
                'icon' => 'nullable|image|mimes:png,svg|max:2048',
                'urutan' => 'required|integer',
            ]);

            // Menghandle upload icon jika ada
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $iconName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('path/to/icon'), $iconName);
                $validatedData['icon'] = $iconName;
            }

            // Simpan data modul baru
            Modul::create($validatedData);

            // Redirect dengan pesan sukses
            return redirect()->route('master.modul')->with('message', 'Modul berhasil ditambahkan');
        } catch (\Exception $e) {
            // Tangkap error dan tampilkan pesan error
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function editModul($id)
    {
        $mode = 'edit';
        $modul = Modul::find($id);

        return view('master.modul.create', [
            'mode' => $mode,
            'modul' => $modul
        ]);
    }

    public function updateModul(Request $request, $id)
    {
        try {
            // Validasi data yang dikirim
            $validatedData = $request->validate([
                'nama_modul' => 'required|string|max:255',
                'tautan' => 'required|string|max:255',
                'icon' => 'nullable|image|mimes:png,svg|max:2048',
                'urutan' => 'required|integer',
            ]);

            // Menghandle upload icon jika ada
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $iconName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('path/to/icon'), $iconName);
                $validatedData['icon'] = $iconName;
            }

            // Simpan data modul baru
            Modul::find($id)->update($validatedData);

            // Redirect dengan pesan sukses
            return redirect()->route('master.modul')->with('message', 'Modul berhasil diubah');
        } catch (\Exception $e) {
            // Tangkap error dan tampilkan pesan error
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroyModul($id)
    {
        try {
            // Hapus data modul
            Modul::find($id)->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('master.modul')->with('message', 'Modul berhasil dihapus');
        } catch (\Exception $e) {
            // Tangkap error dan tampilkan pesan error
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // role
    public function role()
    {
        // get data role
        $roles = Role::all();
        return view('master.role.index', [
            'roles' => $roles
        ]);
    }

    public function createRole()
    {
        $mode = 'tambah';

        return view('master.role.create', [
            'mode' => $mode
        ]);
    }

    public function storeRole(Request $request)
    {
        try {
            // Validasi data yang dikirim
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'deskripsi' => 'required|string',
            ]);

            // Simpan data role baru
            Role::create($validatedData);

            // Redirect dengan pesan sukses
            return redirect()->route('master.role')->with('message', 'Role berhasil ditambahkan');
        } catch (\Exception $e) {
            // Tangkap error dan tampilkan pesan error
            return redirect()->back()->withInput()->with('message',  $e->getMessage());
            // return redirect()->back()->withInput()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function editRole($id)
    {
        $mode = 'edit';
        $role = Role::find($id);

        return view('master.role.create', [
            'mode' => $mode,
            'role' => $role
        ]);
    }

    public function updateRole(Request $request, $id)
    {
        // return 'update role';
    }

    public function destroyRole($id)
    {
        try {
            // Hapus data modul
            Role::find($id)->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('master.role')->with('message', 'Role berhasil dihapus');
        } catch (\Exception $e) {
            // Tangkap error dan tampilkan pesan error
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
