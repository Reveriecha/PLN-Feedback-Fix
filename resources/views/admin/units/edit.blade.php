@extends('layouts.admin')

@section('title', 'Edit Unit')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Unit</h1>

    <div class="bg-white rounded-xl shadow-md p-8">
        <form action="{{ route('admin.units.update', $unit) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Nama Unit</label>
                <input type="text" name="nama_unit" value="{{ old('nama_unit', $unit->nama_unit) }}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 @error('nama_unit') border-red-500 @enderror" 
                       required>
                @error('nama_unit')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" 
                           {{ $unit->is_active ? 'checked' : '' }}
                           class="w-5 h-5 text-cyan-600 rounded focus:ring-2 focus:ring-cyan-500">
                    <span class="ml-2 text-gray-700">Aktif</span>
                </label>
            </div>

            <div class="flex space-x-4">
                <button type="submit" 
                        class="px-6 py-3 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold rounded-lg">
                    Update
                </button>
                     <a href="{{ route('admin.input') }}" 
                         class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold rounded-lg">
                          Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection