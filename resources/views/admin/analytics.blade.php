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
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-4xl font-bold text-gray-800 mb-2">{{ $stats['total_responses'] }}</h3>
            <p class="text-gray-600">Total Feedback Masuk</p>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-4xl font-bold text-gray-800 mb-2">{{ $stats['rata_kepuasan'] }}%</h3>
            <p class="text-gray-600">Rata-rata Kepuasan (1-5)</p>
        </div>
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
                        <span class="text-gray-700 text-sm sm:text-base">Kepuasan - <span id="kepuasanPercent" class="font-semibold">0%</span></span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-5 h-5 sm:w-6 sm:h-6 bg-yellow-400 rounded"></div>
                        <span class="text-gray-700 text-sm sm:text-base">Ketidakpuasan - <span id="ketidakpuasanPercent" class="font-semibold">0%</span></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rating Per Inovasi -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Rating Per Inovasi (Top 5)</h2>
            <span class="text-gray-500 text-xs mb-2">Inovasi dengan rating tertinggi</span>
            <div class="max-h-[300px] overflow-y-auto">
                <div id="ratingList" class="space-y-4">
                    <!-- Will be populated by JavaScript -->
                </div>
            </div>
            <button id="viewMoreRating" class="text-blue-600 hover:text-blue-700 font-medium text-sm mt-4 inline-flex items-center group transition-all">
                <span class="mr-1">Lihat Semua</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Tables -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
        <!-- Kepuasan Per Inovasi -->
        <div class="bg-white rounded-xl shadow-md p-2 sm:p-6 overflow-x-auto">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Jumlah Feedback Per Inovasi (Top 5)</h2>
            <span class="text-gray-500 text-xs mb-2">Inovasi dengan feedback terbanyak</span>
            <div class="max-h-[300px] overflow-y-auto overflow-x-hidden rounded-lg border border-gray-100">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-gray-700 font-semibold">Rank</th>
                            <th class="px-4 py-2 text-left text-gray-700 font-semibold">Nama Inovasi</th>
                            <th class="px-4 py-2 text-right text-gray-700 font-semibold">Jumlah Feedback</th>
                        </tr>
                    </thead>
                    <tbody id="kepuasanPerInovasiTable" class="divide-y divide-gray-200">
                        <!-- Will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>
            <button id="viewMoreKepuasan" class="text-cyan-600 hover:text-cyan-700 font-medium text-sm mt-4 inline-flex items-center group transition-all">
                <span class="mr-1">Lihat Semua</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        <!-- Kepuasan Per Unit -->
        <div class="bg-white rounded-xl shadow-md p-2 sm:p-6 overflow-x-auto">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Jumlah Feedback Per Unit (Top 5)</h2>
            <span class="text-gray-500 text-xs mb-2">Unit dengan feedback terbanyak</span>
            <div class="max-h-[300px] overflow-y-auto overflow-x-hidden rounded-lg border border-gray-100">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-gray-700 font-semibold">Rank</th>
                            <th class="px-4 py-2 text-left text-gray-700 font-semibold">Nama Unit</th>
                            <th class="px-4 py-2 text-right text-gray-700 font-semibold">Jumlah Feedback</th>
                        </tr>
                    </thead>
                    <tbody id="kepuasanPerUnitTable" class="divide-y divide-gray-200">
                        <!-- Will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>
            <button id="viewMoreUnit" class="text-cyan-600 hover:text-cyan-700 font-medium text-sm mt-4 inline-flex items-center group transition-all">
                <span class="mr-1">Lihat Semua</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Latest Feedback Table -->
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
</div>

<!-- Modal Rating -->
<div id="modalRating" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden animate-modal">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-white">Rating Semua Inovasi</h3>
                <p class="text-blue-100 text-sm mt-1">Diurutkan dari rating tertinggi ke terendah</p>
            </div>
            <button onclick="closeModal('modalRating')" class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
            <div class="relative mb-4">
                <input type="text" id="searchRating" placeholder="Cari inovasi..." class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <div id="modalRatingList" class="space-y-3">
                <!-- Will be populated by JavaScript -->
            </div>
        </div>
    </div>
</div>

<!-- Modal Inovasi -->
<div id="modalInovasi" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] flex flex-col animate-modal">
        <div class="bg-gradient-to-r from-cyan-600 to-cyan-700 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div>
                <h3 class="text-xl font-bold text-white">Semua Data Inovasi</h3>
                <p class="text-cyan-100 text-sm mt-1">Diurutkan dari feedback terbanyak ke sedikit</p>
            </div>
            <button onclick="closeModal('modalInovasi')" class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="p-6 flex-shrink-0">
            <div class="relative">
                <input type="text" id="searchInovasi" placeholder="Cari inovasi..." class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>
        <div class="overflow-y-auto flex-1 px-6 pb-6">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 sticky top-0">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Rank</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama Inovasi</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Jumlah Feedback</th>
                    </tr>
                </thead>
                <tbody id="modalInovasiTable" class="divide-y divide-gray-200">
                    <!-- Will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Unit -->
<div id="modalUnit" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] flex flex-col animate-modal">
        <div class="bg-gradient-to-r from-cyan-600 to-cyan-700 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div>
                <h3 class="text-xl font-bold text-white">Semua Data Unit</h3>
                <p class="text-cyan-100 text-sm mt-1">Diurutkan dari feedback terbanyak ke sedikit</p>
            </div>
            <button onclick="closeModal('modalUnit')" class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="p-6 flex-shrink-0">
            <div class="relative">
                <input type="text" id="searchUnit" placeholder="Cari unit..." class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>
        <div class="overflow-y-auto flex-1 px-6 pb-6">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 sticky top-0">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Rank</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama Unit</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Jumlah Feedback</th>
                    </tr>
                </thead>
                <tbody id="modalUnitTable" class="divide-y divide-gray-200">
                    <!-- Will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('styles')
<style>
@keyframes modalSlide {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-modal {
    animation: modalSlide 0.3s ease-out;
}

/* Hide scrollbar tapi tetap bisa scroll */
.overflow-y-auto {
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE and Edge */
}
.overflow-y-auto::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Opera */
}
</style>
@endpush

@push('scripts')
<script>
const colors = { cyan: '#0891b2', yellow: '#fbbf24', blue: '#3b82f6' };
let responsesChart, satisfactionPieChart;
let allKepuasanData = [];
let allUnitData = [];
let allRatingData = [];

async function loadAnalyticsData(period = 'month') {
    try {
        const response = await fetch(`/admin/analytics/data?period=${period}&viewMore=true`);
        const data = await response.json();
        
        updateResponsesChart(data.responses || [], period);
        updateSatisfactionPieChart(data.satisfaction || {kepuasan:0, ketidakpuasan:0});
        
        // Sort dan simpan data lengkap
        allRatingData = (data.ratingPerInovasi || []).sort((a, b) => b.rating - a.rating);
        allKepuasanData = (data.kepuasanPerInovasi || []).sort((a, b) => b.jumlah - a.jumlah);
        allUnitData = (data.kepuasanPerUnit || []).sort((a, b) => b.jumlah - a.jumlah);
        
        // Update dengan top 5
        updateRatingPerInovasi(allRatingData.slice(0, 5));
        updateKepuasanPerInovasi(allKepuasanData.slice(0, 5));
        updateKepuasanPerUnit(allUnitData.slice(0, 5));
        
    } catch (error) {
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
            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            return monthNames[parseInt(month) - 1] + ' ' + year;
        } else if (period === 'week') {
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
            datasets: [{
                data: counts,
                backgroundColor: colors.cyan,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
}

function updateSatisfactionPieChart(data) {
    const canvas = document.getElementById('satisfactionPieChart');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    
    document.getElementById('kepuasanPercent').textContent = data.kepuasan + '%';
    document.getElementById('ketidakpuasanPercent').textContent = data.ketidakpuasan + '%';
    
    if (satisfactionPieChart) satisfactionPieChart.destroy();
    
    satisfactionPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Kepuasan', 'Ketidakpuasan'],
            datasets: [{
                data: [data.kepuasan, data.ketidakpuasan],
                backgroundColor: [colors.cyan, colors.yellow],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + '%';
                        }
                    }
                }
            }
        }
    });
}

function updateRatingPerInovasi(data) {
    const container = document.getElementById('ratingList');
    if (!container) return;
    
    if (!data || data.length === 0) {
        container.innerHTML = '<div class="text-gray-500 text-sm">Tidak ada data rating inovasi.</div>';
        return;
    }
    
    container.innerHTML = data.map((item, index) => {
        const percentage = (item.rating / 5) * 100;
        const medals = ['🥇', '🥈', '🥉'];
        const medal = index < 3 ? medals[index] : `#${index + 1}`;
        return `
            <div>
                <div class="flex items-center justify-between mb-1">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">${medal}</span>
                        <span class="text-sm text-gray-700 font-medium">${item.nama}</span>
                    </div>
                    <span class="text-sm font-bold text-blue-600">${item.rating.toFixed(1)}/5</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-500 h-2.5 rounded-full transition-all duration-300" style="width: ${percentage}%"></div>
                </div>
            </div>
        `;
    }).join('');
}

function updateKepuasanPerInovasi(data) {
    const tbody = document.getElementById('kepuasanPerInovasiTable');
    if (!tbody) return;
    
    if (!data || data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="3" class="py-3 text-gray-500 text-center">Tidak ada data inovasi.</td></tr>';
        return;
    }
    
    tbody.innerHTML = data.map((item, index) => {
        const medals = ['🥇', '🥈', '🥉'];
        const rank = index < 3 ? `<span class='text-2xl'>${medals[index]}</span>` : `<span class='font-bold text-gray-600'>#${index + 1}</span>`;
        return `
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-4 py-2">${rank}</td>
                <td class="px-4 py-2 text-gray-800 font-medium">${item.nama}</td>
                <td class="px-4 py-2 text-right">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-cyan-100 text-cyan-700">
                        ${item.jumlah}
                    </span>
                </td>
            </tr>
        `;
    }).join('');
}

function updateKepuasanPerUnit(data) {
    const tbody = document.getElementById('kepuasanPerUnitTable');
    if (!tbody) return;
    
    if (!data || data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="3" class="py-3 text-gray-500 text-center">Tidak ada data unit.</td></tr>';
        return;
    }
    
    tbody.innerHTML = data.map((item, index) => {
        const medals = ['🥇', '🥈', '🥉'];
        const rank = index < 3 ? `<span class='text-2xl'>${medals[index]}</span>` : `<span class='font-bold text-gray-600'>#${index + 1}</span>`;
        return `
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-4 py-2">${rank}</td>
                <td class="px-4 py-2 text-gray-800 font-medium">${item.nama}</td>
                <td class="px-4 py-2 text-right">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-cyan-100 text-cyan-700">
                        ${item.jumlah}
                    </span>
                </td>
            </tr>
        `;
    }).join('');
}

function showModalRating() {
    const modal = document.getElementById('modalRating');
    const container = document.getElementById('modalRatingList');
    
    container.innerHTML = allRatingData.map((item, index) => {
        const percentage = (item.rating / 5) * 100;
        const medals = ['🥇', '🥈', '🥉'];
        const rank = index < 3 ? medals[index] : `#${index + 1}`;
        return `
            <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">${rank}</span>
                        <span class="text-gray-800 font-medium">${item.nama}</span>
                    </div>
                    <span class="text-lg font-bold text-blue-600">${item.rating.toFixed(1)}/5</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-blue-500 h-3 rounded-full transition-all" style="width: ${percentage}%"></div>
                </div>
            </div>
        `;
    }).join('');
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function showModalInovasi() {
    const modal = document.getElementById('modalInovasi');
    const tbody = document.getElementById('modalInovasiTable');
    
    console.log('Total inovasi data:', allKepuasanData.length);
    console.log('Data:', allKepuasanData);
    
    renderInovasiTable(allKepuasanData, tbody, allKepuasanData);
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function showModalUnit() {
    const modal = document.getElementById('modalUnit');
    const tbody = document.getElementById('modalUnitTable');
    
    console.log('Total unit data:', allUnitData.length);
    console.log('Data:', allUnitData);
    
    renderUnitTable(allUnitData, tbody, allUnitData);
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Helper: Render Inovasi Table (with original rank)
function renderInovasiTable(data, tbody, allData = null) {
    if (!allData) allData = allKepuasanData;
    if (!data || data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="3" class="py-3 text-gray-500 text-center">Tidak ada data inovasi.</td></tr>';
        return;
    }
    tbody.innerHTML = data.map(item => {
        const index = allData.findIndex(d => d.nama === item.nama);
        const medals = ['🥇', '🥈', '🥉'];
        const rank = index < 3 ? `<span class='text-2xl'>${medals[index]}</span>` : `<span class='font-bold text-gray-600'>#${index + 1}</span>`;
        return `
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-4 py-3 text-center align-middle">${rank}</td>
                <td class="px-4 py-3 text-gray-800 font-medium align-middle">${item.nama}</td>
                <td class="px-4 py-3 text-right align-middle">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-cyan-100 text-cyan-700">
                        ${item.jumlah}
                    </span>
                </td>
            </tr>
        `;
    }).join('');
}

// Helper: Render Unit Table (with original rank)
function renderUnitTable(data, tbody, allData = null) {
    if (!allData) allData = allUnitData;
    if (!data || data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="3" class="py-3 text-gray-500 text-center">Tidak ada data unit.</td></tr>';
        return;
    }
    tbody.innerHTML = data.map(item => {
        const index = allData.findIndex(d => d.nama === item.nama);
        const medals = ['🥇', '🥈', '🥉'];
        const rank = index < 3 ? `<span class='text-2xl'>${medals[index]}</span>` : `<span class='font-bold text-gray-600'>#${index + 1}</span>`;
        return `
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-4 py-3 text-center align-middle">${rank}</td>
                <td class="px-4 py-3 text-gray-800 font-medium align-middle">${item.nama}</td>
                <td class="px-4 py-3 text-right align-middle">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-cyan-100 text-cyan-700">
                        ${item.jumlah}
                    </span>
                </td>
            </tr>
        `;
    }).join('');
}

// Search Rating
document.getElementById('searchRating').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const container = document.getElementById('modalRatingList');
    const filtered = allRatingData.filter(item => item.nama.toLowerCase().includes(searchTerm));
    
    container.innerHTML = filtered.map(item => {
        const index = allRatingData.findIndex(d => d.nama === item.nama);
        const percentage = (item.rating / 5) * 100;
        const medals = ['🥇', '🥈', '🥉'];
        const rank = index < 3 ? medals[index] : `#${index + 1}`;
        return `
            <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">${rank}</span>
                        <span class="text-gray-800 font-medium">${item.nama}</span>
                    </div>
                    <span class="text-lg font-bold text-blue-600">${item.rating.toFixed(1)}/5</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-blue-500 h-3 rounded-full transition-all" style="width: ${percentage}%"></div>
                </div>
            </div>
        `;
    }).join('');
});

// Search Inovasi
document.getElementById('searchInovasi').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const tbody = document.getElementById('modalInovasiTable');
    const filtered = allKepuasanData.filter(item => item.nama.toLowerCase().includes(searchTerm));
    renderInovasiTable(filtered, tbody, allKepuasanData);
});

// Search Unit
document.getElementById('searchUnit').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const tbody = document.getElementById('modalUnitTable');
    const filtered = allUnitData.filter(item => item.nama.toLowerCase().includes(searchTerm));
    renderUnitTable(filtered, tbody, allUnitData);
});

// Close modal saat klik di luar
window.addEventListener('click', function(e) {
    if (e.target.id === 'modalRating' || e.target.id === 'modalInovasi' || e.target.id === 'modalUnit') {
        closeModal(e.target.id);
    }
});

// Event listeners
document.getElementById('viewMoreRating').addEventListener('click', showModalRating);
document.getElementById('viewMoreKepuasan').addEventListener('click', showModalInovasi);
document.getElementById('viewMoreUnit').addEventListener('click', showModalUnit);
document.getElementById('periodFilter').addEventListener('change', (e) => loadAnalyticsData(e.target.value));

// Initial load
loadAnalyticsData('month');
</script>
@endpush
@endsection