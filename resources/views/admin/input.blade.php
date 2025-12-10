@extends('layouts.admin')

@section('title', 'Input Unit & Inovasi')

@section('content')
<div class="space-y-8">
    <!-- Units Section -->
    <div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Unit</h1>
            <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.units.create') }}" 
                   class="px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 text-sm w-full sm:w-auto text-center">
                    + Tambah Unit
                </a>
                <form action="{{ route('admin.input.importUnit') }}" method="POST" enctype="multipart/form-data" class="inline w-full sm:w-auto">
                    @csrf
                    <input type="file" name="excel_file" accept=".xlsx,.xls" required class="hidden" id="unit-excel-upload" onchange="this.form.submit()">
                    <button type="button" onclick="document.getElementById('unit-excel-upload').click()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm w-full sm:w-auto">Import Excel</button>
                </form>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-2 sm:p-6 overflow-x-auto">
            <table class="w-full min-w-[480px] sm:min-w-[600px] text-xs sm:text-sm">
                <thead class="bg-gray-50 sticky top-0 z-10">
                    <tr>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-gray-700 whitespace-nowrap">No</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-gray-700 whitespace-nowrap">Nama Unit</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-gray-700 whitespace-nowrap">Status</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-gray-700 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($units as $index => $unit)
                    <tr>
                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                        <td class="px-4 py-3">{{ $unit->nama_unit }}</td>
                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-sm {{ $unit->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $unit->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-2 sm:px-4 py-2 sm:py-3 flex flex-col sm:flex-row gap-1 sm:gap-2">
                            <a href="{{ route('admin.units.edit', $unit) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form action="{{ route('admin.units.destroy', $unit) }}" method="POST" class="inline delete-form-unit">
                                @csrf @method('DELETE')
                                <button type="button" class="text-red-600 hover:text-red-800 btn-hapus-unit" data-id="{{ $unit->id }}">Hapus</button>
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
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Inovasi</h2>
            <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.inovasis.create') }}" 
                   class="px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 text-sm w-full sm:w-auto text-center">
                    + Tambah Inovasi
                </a>
                <form action="{{ route('admin.input.importInovasi') }}" method="POST" enctype="multipart/form-data" class="inline w-full sm:w-auto">
                    @csrf
                    <input type="file" name="excel_file" accept=".xlsx,.xls" required class="hidden" id="inovasi-excel-upload" onchange="this.form.submit()">
                    <button type="button" onclick="document.getElementById('inovasi-excel-upload').click()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm w-full sm:w-auto">Import Excel</button>
                </form>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-2 sm:p-6 overflow-x-auto">
            <table class="w-full min-w-[520px] sm:min-w-[700px] text-xs sm:text-sm">
                <thead class="bg-gray-50 sticky top-0 z-10">
                    <tr>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-gray-700 whitespace-nowrap">No</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-gray-700 whitespace-nowrap">Nama Inovasi</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-gray-700 whitespace-nowrap">Deskripsi</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-gray-700 whitespace-nowrap">Status</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-gray-700 whitespace-nowrap">Aksi</th>
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
                        <td class="px-2 sm:px-4 py-2 sm:py-3 flex flex-col sm:flex-row gap-1 sm:gap-2">
                            <a href="{{ route('admin.inovasis.edit', $inovasi) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form action="{{ route('admin.inovasis.destroy', $inovasi) }}" method="POST" class="inline delete-form-inovasi">
                                @csrf @method('DELETE')
                                <button type="button" class="text-red-600 hover:text-red-800 btn-hapus-inovasi" data-id="{{ $inovasi->id }}">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal Konfirmasi Hapus -->
<!-- Modal konfirmasi custom dihapus, pakai confirm JS standar -->
<!-- Modal Konfirmasi Hapus Custom -->
<div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden px-2">
    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-8 max-w-sm w-full text-center">
        <h2 class="text-lg sm:text-xl font-bold mb-4">Konfirmasi Hapus</h2>
        <p id="deleteModalText" class="mb-6 text-sm sm:text-base">Yakin ingin menghapus data?</p>
        <div class="flex flex-col sm:flex-row justify-center gap-2 sm:space-x-4">
            <button id="confirmDeleteBtn" class="px-4 py-2 sm:px-6 sm:py-2 bg-red-600 text-white rounded-lg">Hapus</button>
            <button id="cancelDeleteBtn" class="px-4 py-2 sm:px-6 sm:py-2 bg-gray-300 text-gray-700 rounded-lg">Batal</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
let deleteTargetBtn = null;
let deleteType = null;
window.addEventListener('DOMContentLoaded', function() {
    // Show custom modal for unit
    document.querySelectorAll('.btn-hapus-unit').forEach(btn => {
        btn.addEventListener('click', function() {
            console.log('Klik hapus unit', btn);
            deleteTargetBtn = btn;
            deleteType = 'unit';
            document.getElementById('deleteModalText').textContent = 'Yakin ingin menghapus unit ini?';
            document.getElementById('deleteModal').classList.remove('hidden');
        });
    });
    // Show custom modal for inovasi
    document.querySelectorAll('.btn-hapus-inovasi').forEach(btn => {
        btn.addEventListener('click', function() {
            console.log('Klik hapus inovasi', btn);
            deleteTargetBtn = btn;
            deleteType = 'inovasi';
            document.getElementById('deleteModalText').textContent = 'Yakin ingin menghapus inovasi ini?';
            document.getElementById('deleteModal').classList.remove('hidden');
        });
    });
    // Confirm delete
    document.getElementById('confirmDeleteBtn').onclick = function() {
        if (!deleteTargetBtn) return;
        const id = deleteTargetBtn.getAttribute('data-id');
        let url = '';
        if (deleteType === 'unit') url = `/admin/units/${id}`;
        if (deleteType === 'inovasi') url = `/admin/inovasis/${id}`;
        console.log('AJAX DELETE', url);
        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        }).then(res => {
            console.log('AJAX response', res);
            if (res.ok) {
                const tr = deleteTargetBtn.closest('tr');
                tr.remove();
                // Update nomor urut di tabel Unit
                if (deleteType === 'unit') {
                    const rows = document.querySelectorAll('table.w-full:nth-of-type(1) tbody tr');
                    rows.forEach((row, idx) => {
                        const noCell = row.querySelector('td');
                        if (noCell) noCell.textContent = idx + 1;
                    });
                }
                // Update nomor urut di tabel Inovasi
                if (deleteType === 'inovasi') {
                    const tables = document.querySelectorAll('table.w-full');
                    const inovasiTable = tables.length > 1 ? tables[1] : null;
                    if (inovasiTable) {
                        const rows = inovasiTable.querySelectorAll('tbody tr');
                        rows.forEach((row, idx) => {
                            const noCell = row.querySelector('td');
                            if (noCell) noCell.textContent = idx + 1;
                        });
                    }
                }
                // Hilangkan fokus dari tombol
                deleteTargetBtn.blur();
                document.getElementById('deleteModal').classList.add('hidden');
                deleteTargetBtn = null;
                deleteType = null;
            } else {
                // Fallback: submit form biasa jika AJAX gagal
                const form = deleteTargetBtn.closest('form');
                form.submit();
            }
        }).catch((err) => {
            console.error('AJAX error', err);
            // Fallback: submit form biasa jika AJAX error
            const form = deleteTargetBtn.closest('form');
            form.submit();
        });
    };
    // Cancel delete
    document.getElementById('cancelDeleteBtn').onclick = function() {
        document.getElementById('deleteModal').classList.add('hidden');
        deleteTargetBtn = null;
        deleteType = null;
    };
});
</script>
<script>
let deleteForm = null;
function showDeleteModal(type, btn) {
    deleteForm = btn.closest('form');
    document.getElementById('deleteModalText').textContent = type === 'unit' ? 'Yakin ingin menghapus unit ini?' : 'Yakin ingin menghapus inovasi ini?';
    document.getElementById('deleteModal').classList.remove('hidden');
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    deleteForm = null;
}
document.getElementById('confirmDeleteBtn').onclick = function() {
    if (deleteForm) deleteForm.submit();
    closeDeleteModal();
};
</script>
@endpush
@endsection
