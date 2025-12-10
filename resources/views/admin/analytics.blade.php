@extends('layouts.admin')

@section('title', 'Analytics')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2 gap-2">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Analytics Feedback</h1>
        <span class="text-gray-500 text-sm sm:text-base">Visualisasi data feedback inovasi & unit</span>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
        <!-- Total Responses -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-4xl font-bold text-gray-800 mb-2">{{ $stats['total_responses'] }}</h3>
            <p class="text-gray-600">Total Feedback Masuk</p>
        </div>

        <!-- Rata Kepuasan -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-4xl font-bold text-gray-800 mb-2">{{ $stats['rata_kepuasan'] }}%</h3>
            <p class="text-gray-600">Rata-rata Kepuasan (1-5)</p>
        </div>

        <!-- Rata Ketidakpuasan -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-4xl font-bold text-gray-800 mb-2">{{ $stats['rata_ketidakpuasan'] }}%</h3>
            <p class="text-gray-600">Rata-rata Ketidakpuasan</p>
        </div>
    </div>

    <!-- Responses Chart -->
    <div class="bg-white rounded-xl shadow-md p-2 sm:p-6 flex flex-col min-h-[300px]" style="height:350px;">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2 gap-2">
            <h2 class="text-lg font-semibold text-gray-800">Trend Feedback Masuk</h2>
            <select id="periodFilter" class="w-full sm:w-auto px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 text-xs sm:text-sm mt-2 sm:mt-0">
                <option value="month">Per Bulan</option>
                <option value="year">Per Tahun</option>
                <option value="week">Per Minggu</option>
            </select>
        </div>
        <span class="text-gray-500 text-xs mb-2">Menampilkan jumlah feedback yang masuk berdasarkan waktu</span>
        <div class="flex-1 flex items-center justify-center">
            <canvas id="responsesChart" height="80"></canvas>
        </div>
    </div>

    <!-- Pie Chart and Rating -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
        <!-- Kepuasan vs Ketidakpuasan -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Distribusi Kepuasan</h2>
            <span class="text-gray-500 text-xs mb-2">Persentase feedback yang puas dan tidak puas</span>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <div class="relative w-40 h-40 sm:w-64 sm:h-64 mx-auto">
                    <canvas id="satisfactionPieChart"></canvas>
                </div>
                <div class="sm:ml-8 space-y-3 flex flex-col">
                    <div class="flex items-center space-x-3">
                        <div class="w-5 h-5 sm:w-6 sm:h-6 bg-cyan-600 rounded"></div>
                        <span class="text-gray-700 text-sm sm:text-base">Kepuasan - <span id="kepuasanPercent" class="font-semibold">91%</span></span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-5 h-5 sm:w-6 sm:h-6 bg-yellow-400 rounded"></div>
                        <span class="text-gray-700 text-sm sm:text-base">Ketidakpuasan - <span id="ketidakpuasanPercent" class="font-semibold">9%</span></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rating Per Inovasi -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Rating Per Inovasi</h2>
            <span class="text-gray-500 text-xs mb-2">Rata-rata rating tiap inovasi</span>
            <div id="ratingList" class="space-y-4">
                <!-- Will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Tables -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
        <!-- Kepuasan Per Inovasi -->
        <div class="bg-white rounded-xl shadow-md p-2 sm:p-6 overflow-x-auto">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Kepuasan Per Inovasi</h2>
            <span class="text-gray-500 text-xs mb-2">Jumlah feedback per inovasi</span>
            <table class="w-full">
                <tbody id="kepuasanPerInovasiTable" class="divide-y divide-gray-200">
                    <!-- Will be populated by JavaScript -->
                </tbody>
            </table>
            <a href="#" class="text-cyan-600 hover:text-cyan-700 text-sm mt-4 inline-block">View More..</a>
        </div>

        <!-- Kepuasan Per Unit -->
        <div class="bg-white rounded-xl shadow-md p-2 sm:p-6 overflow-x-auto">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Kepuasan Per Unit</h2>
            <span class="text-gray-500 text-xs mb-2">Jumlah feedback per unit</span>
            <table class="w-full">
                <tbody id="kepuasanPerUnitTable" class="divide-y divide-gray-200">
                    <!-- Will be populated by JavaScript -->
                </tbody>
            </table>
            <a href="#" class="text-cyan-600 hover:text-cyan-700 text-sm mt-4 inline-block">View More..</a>
        </div>
    </div>
</div>

@push('scripts')
<script>
const colors = { cyan: '#0891b2', yellow: '#fbbf24', blue: '#3b82f6' };
let responsesChart, satisfactionPieChart;

async function loadAnalyticsData(period = 'month') {
    try {
        const response = await fetch(`/admin/analytics/data?period=${period}`);
        const data = await response.json();
        // Fallback if data is missing
        updateResponsesChart(data.responses || [], period);
        updateSatisfactionPieChart(data.satisfaction || {kepuasan:0, ketidakpuasan:0});
        updateRatingPerInovasi(data.ratingPerInovasi || []);
        updateKepuasanPerInovasi(data.kepuasanPerInovasi || []);
        updateKepuasanPerUnit(data.kepuasanPerUnit || []);
    } catch (error) {
        // Render empty charts if error
        updateResponsesChart([], period);
        updateSatisfactionPieChart({kepuasan:0, ketidakpuasan:0});
        updateRatingPerInovasi([]);
        updateKepuasanPerInovasi([]);
        updateKepuasanPerUnit([]);
        console.error('Error loading analytics:', error);
    }
}

function updateResponsesChart(data, period) {
    const canvas = document.getElementById('responsesChart');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    const labels = data.length > 0 ? data.map(item => {
        if (period === 'month') {
            const [year, month] = item.period.split('-');
            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Des'];
            return monthNames[parseInt(month) - 1] + ' ' + year;
        } else if (period === 'week') {
            // Format: year-weeknumber
            const [year, week] = item.period.split('-');
            return 'Minggu ' + week + ' ' + year;
        }
        return item.period;
    }) : ['Tidak ada data'];
    const counts = data.length > 0 ? data.map(item => item.count) : [0];
    if (responsesChart) responsesChart.destroy();
    responsesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{ data: counts, backgroundColor: colors.cyan, borderRadius: 8 }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 50 } } }
        }
    });
}

function updateSatisfactionPieChart(data) {
    const canvas = document.getElementById('satisfactionPieChart');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    document.getElementById('kepuasanPercent').textContent = (data.kepuasan ?? 0) + '%';
    document.getElementById('ketidakpuasanPercent').textContent = (data.ketidakpuasan ?? 0) + '%';
    if (satisfactionPieChart) satisfactionPieChart.destroy();
    satisfactionPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Kepuasan', 'Ketidakpuasan'],
            datasets: [{ data: [data.kepuasan ?? 0, data.ketidakpuasan ?? 0], backgroundColor: [colors.cyan, colors.yellow], borderWidth: 0 }]
        },
        options: { responsive: true, maintainAspectRatio: true, cutout: '60%', plugins: { legend: { display: false } } }
    });
}

function updateRatingPerInovasi(data) {
    const container = document.getElementById('ratingList');
    if (!container) return;
    if (!data || data.length === 0) {
        container.innerHTML = '<div class="text-gray-500">Tidak ada data rating inovasi.</div>';
        return;
    }
    container.innerHTML = data.map(item => {
        const percentage = (item.rating / 5) * 100;
        return `
            <div>
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm text-gray-700">${item.nama}</span>
                    <span class="text-sm text-gray-500">${item.rating.toFixed(1)}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: ${percentage}%"></div>
                </div>
            </div>
        `;
    }).join('');
}

function updateKepuasanPerInovasi(data) {
    const tbody = document.getElementById('kepuasanPerInovasiTable');
    if (!tbody) return;
    if (!data || data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="2" class="py-3 text-gray-500">Tidak ada data inovasi.</td></tr>';
        return;
    }
    tbody.innerHTML = data.map(item => `
        <tr><td class="py-3 text-gray-700">${item.nama}</td><td class="py-3 text-right text-gray-700">${item.jumlah}</td></tr>
    `).join('');
}

function updateKepuasanPerUnit(data) {
    const tbody = document.getElementById('kepuasanPerUnitTable');
    if (!tbody) return;
    if (!data || data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="2" class="py-3 text-gray-500">Tidak ada data unit.</td></tr>';
        return;
    }
    tbody.innerHTML = data.map(item => `
        <tr><td class="py-3 text-gray-700">${item.nama}</td><td class="py-3 text-right text-gray-700">${item.jumlah}</td></tr>
    `).join('');
}

document.getElementById('periodFilter').addEventListener('change', (e) => loadAnalyticsData(e.target.value));
loadAnalyticsData('month');
</script>
@endpush
<div class="bg-white rounded-xl shadow-md p-2 sm:p-6 mt-8 overflow-x-auto">
    <h2 class="text-lg font-semibold text-gray-800 mb-2">Feedback & Saran Terbaru</h2>
    <span class="text-gray-500 text-xs mb-2">Menampilkan 5 feedback/saran terbaru dari user</span>
    <table class="w-full min-w-[480px] sm:min-w-[600px] text-xs sm:text-sm mt-2">
        <thead class="bg-gray-50 sticky top-0 z-10">
            <tr>
                <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-gray-700 font-semibold whitespace-nowrap">Nama</th>
                <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-gray-700 font-semibold whitespace-nowrap">Unit</th>
                <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-gray-700 font-semibold whitespace-nowrap">Inovasi</th>
                <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-gray-700 font-semibold whitespace-nowrap">Feedback</th>
                <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-gray-700 font-semibold whitespace-nowrap">Saran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($latestFeedbacks as $feedback)
            <tr class="hover:bg-gray-50">
                <td class="px-2 sm:px-4 py-2 sm:py-3">{{ $feedback->nama }}</td>
                <td class="px-2 sm:px-4 py-2 sm:py-3">{{ $feedback->unit->nama_unit }}</td>
                <td class="px-2 sm:px-4 py-2 sm:py-3">{{ $feedback->inovasi->nama_inovasi }}</td>
                <td class="px-2 sm:px-4 py-2 sm:py-3">{{ $feedback->feedback ?? '-' }}</td>
                <td class="px-2 sm:px-4 py-2 sm:py-3">{{ $feedback->saran ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-2 sm:px-4 py-8 text-center text-gray-500">Belum ada data feedback</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection