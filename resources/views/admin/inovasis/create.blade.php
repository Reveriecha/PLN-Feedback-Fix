@extends('layouts.admin')

@section('title', 'Tambah Inovasi')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Inovasi Baru</h1>

    <div class="bg-white rounded-xl shadow-md p-8">
        <form action="{{ route('admin.inovasis.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Nama Inovasi</label>
                <input type="text" name="nama_inovasi" value="{{ old('nama_inovasi') }}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 @error('nama_inovasi') border-red-500 @enderror" 
                       placeholder="Contoh: PolyPurple Email Subscription" required>
                @error('nama_inovasi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="4" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 resize-none"
                          placeholder="Deskripsi singkat tentang inovasi ini...">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="flex space-x-4">
                    <button type="submit" 
                            class="px-6 py-3 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold rounded-lg">
                        Simpan
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