@extends('layouts.admin')

@section('title', 'Feedback Response')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Feedback Response</h1>
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 w-full sm:w-auto">
            <a href="{{ route('admin.feedbacks.export.excel') }}" 
               class="px-4 sm:px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center space-x-2 text-sm sm:text-base w-full sm:w-auto justify-center">
                <span>Export to CSV</span>
            </a>
            <a href="{{ route('admin.feedbacks.export.pdf') }}" 
               class="px-4 sm:px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 flex items-center space-x-2 text-sm sm:text-base w-full sm:w-auto justify-center">
                <span>Export to PDF</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-2 sm:p-6">
        <form method="GET" class="flex flex-col sm:flex-row gap-2 sm:gap-4 mb-6 w-full">
            <select name="inovasi_id" class="w-full sm:w-auto px-3 sm:px-4 py-2 border border-gray-300 rounded-lg text-xs sm:text-sm" onchange="this.form.submit()">
                <option value="">Semua Inovasi</option>
                @foreach($inovasis as $inovasi)
                    <option value="{{ $inovasi->id }}" {{ request('inovasi_id') == $inovasi->id ? 'selected' : '' }}>{{ $inovasi->nama_inovasi }}</option>
                @endforeach
            </select>
            <select name="period" class="w-full sm:w-auto px-3 sm:px-4 py-2 border border-gray-300 rounded-lg text-xs sm:text-sm" onchange="this.form.submit()">
                <option value="">Semua Waktu</option>
                <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
            </select>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Nama</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">NIP</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Unit</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Inovasi</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Lama</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Rating</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Feedback</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Saran</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($feedbacks as $feedback)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-semibold">{{ $feedback->nama }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $feedback->nip }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $feedback->unit->nama_unit }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $feedback->inovasi->nama_inovasi }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $feedback->lama_implementasi }} bln</td>
                        <td class="px-4 py-3 text-gray-600">{{ $feedback->average_rating }}/5</td>
                        <td class="px-4 py-3 text-gray-600">{{ $feedback->feedback ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $feedback->saran ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <form action="{{ route('admin.feedbacks.destroy', $feedback) }}" method="POST" 
                                  onsubmit="return confirm('Yakin hapus feedback ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                            Belum ada data feedback
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $feedbacks->links() }}
        </div>
    </div>
</div>
@endsection