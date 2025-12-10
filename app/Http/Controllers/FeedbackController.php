<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Unit;
use App\Models\Inovasi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FeedbackController extends Controller
{
    // User: Form Feedback
    public function create()
    {
        $units = Unit::where('is_active', true)->get();
        $inovasis = Inovasi::where('is_active', true)->get();
        
        return view('feedback.create', compact('units', 'inovasis'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50',
            'unit_id' => 'required|exists:units,id',
            'inovasi_id' => 'required|exists:inovasis,id',
            'lama_implementasi' => 'required|integer|min:1',
            'rating_kemudahan' => 'required|integer|min:1|max:5',
            'rating_kesesuaian' => 'required|integer|min:1|max:5',
            'rating_keandalan' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string',
            'saran' => 'nullable|string',
        ]);
        
        Feedback::create($validated);
        
        return redirect()->route('feedback.success');
    }
    
    public function success()
    {
        return view('feedback.success');
    }
    
    // Admin: Data Table
    public function index(Request $request)
    {
        $inovasis = Inovasi::where('is_active', true)->get();
        $query = Feedback::with(['unit', 'inovasi']);

        // Filter by inovasi
        if ($request->has('inovasi_id') && $request->inovasi_id != '') {
            $query->where('inovasi_id', $request->inovasi_id);
        }

        // Filter by week/month
        if ($request->has('period') && $request->period != '') {
            if ($request->period == 'week') {
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($request->period == 'month') {
                $query->whereMonth('created_at', now()->month);
            }
        }

        $feedbacks = $query->latest()->paginate(15);

        return view('admin.feedbacks.index', compact('feedbacks', 'inovasis'));
    }
    
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        
        return redirect()->route('admin.feedbacks')
            ->with('success', 'Feedback berhasil dihapus');
    }
    
    // Export Excel - SEMENTARA EXPORT KE CSV BIASA
    public function exportExcel()
    {
        // Export only filtered data
        $query = Feedback::with(['unit', 'inovasi']);
        if (request()->has('inovasi_id') && request()->inovasi_id != '') {
            $query->where('inovasi_id', request()->inovasi_id);
        }
        if (request()->has('period') && request()->period != '') {
            if (request()->period == 'week') {
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif (request()->period == 'month') {
                $query->whereMonth('created_at', now()->month);
            }
        }
        $feedbacks = $query->get();
        
        $filename = 'feedback-inovasi-pln-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($feedbacks) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'No', 'Nama', 'NIP', 'Unit', 'Inovasi', 
                'Lama Implementasi (Bulan)', 
                'Rating Kemudahan', 'Rating Kesesuaian', 'Rating Keandalan',
                'Rata-rata Rating', 'Feedback', 'Saran', 'Tanggal Submit'
            ]);
            
            // Data
            $no = 1;
            foreach ($feedbacks as $feedback) {
                fputcsv($file, [
                    $no++,
                    $feedback->nama,
                    $feedback->nip,
                    $feedback->unit->nama_unit,
                    $feedback->inovasi->nama_inovasi,
                    $feedback->lama_implementasi,
                    $feedback->rating_kemudahan,
                    $feedback->rating_kesesuaian,
                    $feedback->rating_keandalan,
                    $feedback->average_rating,
                    $feedback->feedback ?? '-',
                    $feedback->saran ?? '-',
                    $feedback->created_at->format('d-m-Y H:i'),
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    // Export PDF
    public function exportPdf()
    {
        $feedbacks = Feedback::with(['unit', 'inovasi'])->get();
        
        $pdf = Pdf::loadView('admin.feedbacks.pdf', compact('feedbacks'));
        
        return $pdf->download('feedback-inovasi-pln-' . date('Y-m-d') . '.pdf');
    }
}