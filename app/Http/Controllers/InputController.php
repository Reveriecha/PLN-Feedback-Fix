<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Inovasi;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

class InputController extends Controller
{
    public function index()
    {
        $units = Unit::latest()->get();
        $inovasis = Inovasi::latest()->get();
        return view('admin.input', compact('units', 'inovasis'));
    }

    // Import Excel Unit
    public function importUnit(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);
        $data = Excel::toArray([], $request->file('excel_file'));
        \Log::info('Excel importUnit data:', $data);
        $rows = $data[0] ?? [];
        if (count($rows) < 2) {
            return redirect()->route('admin.input')->with('error', 'Format Excel unit tidak sesuai.');
        }
        $header = array_map('strtolower', array_map('trim', $rows[0]));
        foreach (array_slice($rows, 1) as $row) {
            $rowData = array_combine($header, $row);
            if (!empty($rowData['unit'])) {
                Unit::updateOrCreate(
                    ['nama_unit' => $rowData['unit']],
                    ['is_active' => isset($rowData['is_active']) ? (bool)$rowData['is_active'] : true]
                );
            }
        }
        return redirect()->route('admin.input')->with('success', 'Import Excel unit berhasil.');
    }

    // Import Excel Inovasi
    public function importInovasi(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);
        $data = Excel::toArray([], $request->file('excel_file'));
        \Log::info('Excel importInovasi data:', $data);
        $rows = $data[0] ?? [];
        if (count($rows) < 2) {
            return redirect()->route('admin.input')->with('error', 'Format Excel inovasi tidak sesuai.');
        }
        // Normalisasi header: lowercase, hapus spasi dan underscore
        $rawHeader = $rows[0];
        $headerMap = [];
        foreach ($rawHeader as $i => $h) {
            $key = strtolower(str_replace([' ', '_'], '', trim($h)));
            $headerMap[$i] = $key;
        }
        foreach (array_slice($rows, 1) as $row) {
            $rowData = [];
            foreach ($row as $i => $val) {
                $headerKey = $headerMap[$i] ?? null;
                if ($headerKey) {
                    $rowData[$headerKey] = $val;
                }
            }
            // Cari nama inovasi
            $namaInovasi = $rowData['namainovasi'] ?? $rowData['inovasi'] ?? null;
            if (!empty($namaInovasi)) {
                Inovasi::updateOrCreate(
                    ['nama_inovasi' => $namaInovasi],
                    [
                        'deskripsi' => $rowData['deskripsi'] ?? '',
                        'is_active' => isset($rowData['isactive']) ? (bool)$rowData['isactive'] : true,
                        // Tambahkan unit jika ada
                        'unit' => $rowData['unit'] ?? $rowData['namaunit'] ?? null
                    ]
                );
            }
        }
        return redirect()->route('admin.input')->with('success', 'Import Excel inovasi berhasil.');
    }
}
