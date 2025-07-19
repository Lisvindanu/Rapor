<?php

namespace App\Http\Controllers;

use App\Models\KeuanganProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class KeuanganProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = KeuanganProgram::query();

            // Filter berdasarkan nama jika ada
            if ($request->filled('search')) {
                $query->byNama($request->search);
            }

            $programs = $query->orderBy('nama_program', 'asc')->get();

            return view('keuangan.master.program.index', compact('programs'));

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('keuangan.master.program.create');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_program' => 'required|string|max:100|unique:keuangan_program,nama_program',
            ], [
                'nama_program.required' => 'Nama program wajib diisi.',
                'nama_program.unique' => 'Nama program sudah ada.',
                'nama_program.max' => 'Nama program maksimal 100 karakter.'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            KeuanganProgram::create([
                'nama_program' => $request->nama_program
            ]);

            return redirect()->route('keuangan.program.index')
                ->with('message', 'Program berhasil ditambahkan.');

        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $program = KeuanganProgram::findOrFail($id);
            return view('keuangan.master.program.show', compact('program'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $program = KeuanganProgram::findOrFail($id);
            return view('keuangan.master.program.edit', compact('program'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $program = KeuanganProgram::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'nama_program' => 'required|string|max:100|unique:keuangan_program,nama_program,' . $id,
            ], [
                'nama_program.required' => 'Nama program wajib diisi.',
                'nama_program.unique' => 'Nama program sudah ada.',
                'nama_program.max' => 'Nama program maksimal 100 karakter.'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $program->update([
                'nama_program' => $request->nama_program
            ]);

            return redirect()->route('keuangan.program.index')
                ->with('message', 'Program berhasil diperbarui.');

        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $program = KeuanganProgram::findOrFail($id);

            // TODO: Cek apakah program sedang digunakan di transaksi lain
            // if ($program->hasRelatedTransactions()) {
            //     return response()->json([
            //         'message' => 'Tidak dapat menghapus program yang sedang digunakan.'
            //     ], 400);
            // }

            $program->delete();

            return response()->json([
                'message' => 'Program berhasil dihapus.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
