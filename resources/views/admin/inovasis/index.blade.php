
@extends('layouts.admin')

@section('title', 'Input Unit & Inovasi')

@section('content')
<div class="space-y-8">
    <!-- Units Section -->
    <div>
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Unit</h1>
            <a href="{{ route('admin.units.create') }}" 
               class="px-6 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700">
                + Tambah Unit
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-700">No</th>
                        <th class="px-4 py-3 text-left text-gray-700">Nama Unit</th>
                        <th class="px-4 py-3 text-left text-gray-700">Status</th>
                        <th class="px-4 py-3 text-left text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach(\App\Models\Unit::all() as $index => $unit)
                    <tr>
                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                        <td class="px-4 py-3">{{ $unit->nama_unit }}</td>
                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-sm {{ $unit->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $unit->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('admin.units.edit', $unit) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form action="{{ route('admin.units.destroy', $unit) }}" method="POST" class="inline" 
                                  onsubmit="return confirm('Yakin hapus unit ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Inovasi Section -->
    <div>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Inovasi</h2>
            <a href="{{ route('admin.inovasis.create') }}" 
               class="px-6 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700">
                + Tambah Inovasi
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-700">No</th>
                        <th class="px-4 py-3 text-left text-gray-700">Nama Inovasi</th>
                        <th class="px-4 py-3 text-left text-gray-700">Deskripsi</th>
                        <th class="px-4 py-3 text-left text-gray-700">Status</th>
                        <th class="px-4 py-3 text-left text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($inovasis as $index => $inovasi)
                    <tr>
                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                        <td class="px-4 py-3">{{ $inovasi->nama_inovasi }}</td>
                        <td class="px-4 py-3">{{ Str::limit($inovasi->deskripsi, 50) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-sm {{ $inovasi->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $inovasi->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('admin.inovasis.edit', $inovasi) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form action="{{ route('admin.inovasis.destroy', $inovasi) }}" method="POST" class="inline" 
                                  onsubmit="return confirm('Yakin hapus inovasi ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
