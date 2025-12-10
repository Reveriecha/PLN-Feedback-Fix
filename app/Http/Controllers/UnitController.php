<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function create()
    {
        return view('admin.units.create');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);
        // TODO: Proses file Excel dan simpan data unit
        return redirect()->route('admin.input')->with('success', 'Import Excel unit berhasil (dummy).');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_unit' => 'required|string|max:255|unique:units,nama_unit',
        ]);
        Unit::create($validated + ['is_active' => true]);
        return redirect()->route('admin.input')
            ->with('success', 'Unit berhasil ditambahkan');
    }

    public function edit(Unit $unit)
    {
        return view('admin.units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'nama_unit' => 'required|string|max:255|unique:units,nama_unit,' . $unit->id,
            'is_active' => 'boolean',
        ]);
        $unit->update($validated);
        return redirect()->route('admin.input')
            ->with('success', 'Unit berhasil diupdate');
    }

    public function destroy(Unit $unit)
    {
        \Log::info('UnitController@destroy', [
            'unit_id' => $unit->id,
            'ajax' => request()->ajax(),
            'method' => request()->method(),
            'url' => request()->url(),
        ]);
        $unit->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.input')
            ->with('success', 'Unit berhasil dihapus');
    }
}