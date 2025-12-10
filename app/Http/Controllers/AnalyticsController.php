<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Unit;
use App\Models\Inovasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $stats = $this->getStatistics();
        $latestFeedbacks = Feedback::with(['unit', 'inovasi'])
            ->latest()->limit(5)->get();
        return view('admin.analytics', compact('stats', 'latestFeedbacks'));
    }
    
    public function getData(Request $request)
    {
        $period = $request->get('period', 'month');
        $viewMore = $request->get('viewMore', false);
        
        return response()->json([
            'responses' => $this->getResponsesData($period),
            'satisfaction' => $this->getSatisfactionData(),
            'ratingPerInovasi' => $this->getRatingPerInovasi(),
            'kepuasanPerInovasi' => $this->getKepuasanPerInovasi($viewMore ? null : 5),
            'kepuasanPerUnit' => $this->getKepuasanPerUnit($viewMore ? null : 5),
        ]);
    }
    
    private function getStatistics()
    {
        $totalResponses = Feedback::count();
        
        // Rata-rata kepuasan (dari rating 1-5 jadi persentase)
        $avgKepuasan = Feedback::selectRaw('
            AVG((rating_kemudahan + rating_kesesuaian + rating_keandalan) / 3) as avg_rating
        ')->first()->avg_rating;
        
        $rataKepuasan = $avgKepuasan ? round(($avgKepuasan / 5) * 100) : 0;
        $rataKetidakpuasan = 100 - $rataKepuasan;
        
        return [
            'total_responses' => $totalResponses,
            'rata_kepuasan' => $rataKepuasan,
            'rata_ketidakpuasan' => $rataKetidakpuasan,
        ];
    }
    
    private function getResponsesData($period)
    {
        if ($period === 'year') {
            $format = '%Y';
        } elseif ($period === 'week') {
            $format = '%x-%v'; // ISO year-week
        } else {
            $format = '%Y-%m';
        }

        $data = Feedback::selectRaw("DATE_FORMAT(created_at, '{$format}') as period, COUNT(*) as count")
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        return $data;
    }
    
    private function getSatisfactionData()
    {
        $total = Feedback::count();
        
        if ($total == 0) {
            return ['kepuasan' => 0, 'ketidakpuasan' => 0];
        }
        
        $kepuasan = Feedback::whereRaw('(rating_kemudahan + rating_kesesuaian + rating_keandalan) / 3 >= 3.5')->count();
        
        $persenKepuasan = round(($kepuasan / $total) * 100);
        $persenKetidakpuasan = 100 - $persenKepuasan;
        
        return [
            'kepuasan' => $persenKepuasan,
            'ketidakpuasan' => $persenKetidakpuasan,
        ];
    }
    
    private function getRatingPerInovasi()
    {
        return Inovasi::withCount('feedbacks')
            ->with(['feedbacks' => function($q) {
                $q->selectRaw('inovasi_id, AVG((rating_kemudahan + rating_kesesuaian + rating_keandalan) / 3) as avg_rating')
                  ->groupBy('inovasi_id');
            }])
            ->where('is_active', true)
            ->get()
            ->map(function($inovasi) {
                $avgRating = 0;
                if ($inovasi->feedbacks->count() > 0) {
                    $avgRating = $inovasi->feedbacks->first()->avg_rating ?? 0;
                }
                
                return [
                    'nama' => $inovasi->nama_inovasi,
                    'jumlah' => $inovasi->feedbacks_count,
                    'rating' => round($avgRating, 2),
                ];
            });
    }
    
    private function getKepuasanPerInovasi($limit = null)
    {
        $query = Inovasi::withCount('feedbacks')
            ->where('is_active', true)
            ->orderByDesc('feedbacks_count');
        
        if ($limit) {
            $query->limit($limit);
        }
        
        return $query->get()
            ->map(function($inovasi) {
                return [
                    'nama' => $inovasi->nama_inovasi,
                    'jumlah' => $inovasi->feedbacks_count,
                ];
            });
    }
    
    private function getKepuasanPerUnit($limit = null)
    {
        $query = Unit::withCount('feedbacks')
            ->where('is_active', true)
            ->orderByDesc('feedbacks_count');
        
        if ($limit) {
            $query->limit($limit);
        }
        
        return $query->get()
            ->map(function($unit) {
                return [
                    'nama' => $unit->nama_unit,
                    'jumlah' => $unit->feedbacks_count,
                ];
            });
    }
}