<?php

namespace App\Http\Controllers;

use App\Models\Inovasi;
use Illuminate\Http\Request;

class InovasiController extends Controller
{
    public function create()
    {
        return view('admin.inovasis.create');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);
        // TODO: Proses file Excel dan simpan data inovasi
        return redirect()->route('admin.input')->with('success', 'Import Excel inovasi berhasil (dummy).');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_inovasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);
        Inovasi::create($validated + ['is_active' => true]);
        return redirect()->route('admin.input')
            ->with('success', 'Inovasi berhasil ditambahkan');
    }

    public function edit(Inovasi $inovasi)
    {
        return view('admin.inovasis.edit', compact('inovasi'));
    }

    public function update(Request $request, Inovasi $inovasi)
    {
        $validated = $request->validate([
            'nama_inovasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        $inovasi->update($validated);
        return redirect()->route('admin.input')
            ->with('success', 'Inovasi berhasil diupdate');
    }

    public function destroy(Inovasi $inovasi)
    {
        \Log::info('InovasiController@destroy', [
            'inovasi_id' => $inovasi->id,
            'ajax' => request()->ajax(),
            'method' => request()->method(),
            'url' => request()->url(),
        ]);
        $inovasi->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.input')
            ->with('success', 'Inovasi berhasil dihapus');
    }
}