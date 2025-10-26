@extends('layouts.admin')

@section('title', 'Proses Pengembalian')

@section('content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Proses Pengembalian Buku</h2>
        <a href="{{ route('admin.pengembalian.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm">
        <form action="{{ route('admin.pengembalian.store') }}" method="POST">
            @csrf

            <!-- Pilih Peminjaman -->
            <div class="mb-6">
                <label for="peminjaman_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Peminjaman *</label>
                <select name="peminjaman_id" id="peminjaman_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Peminjaman --</option>
                    @foreach($peminjamans as $peminjaman)
                        <option value="{{ $peminjaman->id }}" {{ request('peminjaman_id') == $peminjaman->id ? 'selected' : '' }}>
                            PMJ-{{ str_pad($peminjaman->id, 4, '0', STR_PAD_LEFT) }} - {{ $peminjaman->buku->judul }} ({{ $peminjaman->member->nama }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Detail Peminjaman -->
            <div id="peminjaman-detail" class="hidden mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">Detail Peminjaman</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h4 class="font-medium text-blue-800">Data Buku</h4>
                        <p id="detail-judul" class="text-sm text-gray-800"></p>
                        <p id="detail-penulis" class="text-sm text-gray-600"></p>
                    </div>
                    <div>
                        <h4 class="font-medium text-blue-800">Data Member</h4>
                        <p id="detail-member" class="text-sm text-gray-800"></p>
                        <p id="detail-email" class="text-sm text-gray-600"></p>
                    </div>
                    <div>
                        <h4 class="font-medium text-blue-800">Tanggal</h4>
                        <p id="detail-pinjam" class="text-sm text-gray-800"></p>
                        <p id="detail-kembali" class="text-sm text-gray-800"></p>
                    </div>
                    <div>
                        <h4 class="font-medium text-blue-800">Status</h4>
                        <p id="detail-status" class="text-sm text-gray-800"></p>
                        <p id="detail-terlambat" class="text-sm text-red-600 font-medium"></p>
                    </div>
                </div>
            </div>

            <!-- Data Pengembalian -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="tanggal_dikembalikan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Dikembalikan *</label>
                    <input type="date" name="tanggal_dikembalikan" id="tanggal_dikembalikan"
                           value="{{ old('tanggal_dikembalikan', date('Y-m-d')) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="denda" class="block text-sm font-medium text-gray-700 mb-2">Denda (Rp)</label>
                    <input type="number" name="denda" id="denda" value="{{ old('denda', 0) }}" min="0" readonly
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Denda dihitung otomatis berdasarkan keterlambatan</p>
                </div>
            </div>

            <div class="mb-6">
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('keterangan') }}</textarea>
            </div>

            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('admin.pengembalian.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition">
                    Batal
                </a>
                <button type="submit" class="btn-primary text-white px-6 py-3 rounded-lg font-medium transition flex items-center">
                    <i class="fas fa-check-circle mr-2"></i> Proses Pengembalian
                </button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const peminjamanSelect = document.getElementById('peminjaman_id');
    const peminjamanDetail = document.getElementById('peminjaman-detail');
    const tanggalKembaliInput = document.getElementById('tanggal_dikembalikan');
    const dendaInput = document.getElementById('denda');

    const peminjamanData = @json($peminjamans->keyBy('id'));

    peminjamanSelect.addEventListener('change', function() {
        const peminjamanId = this.value;
        
        if (peminjamanId && peminjamanData[peminjamanId]) {
            const data = peminjamanData[peminjamanId];
            
            document.getElementById('detail-judul').textContent = data.buku.judul;
            document.getElementById('detail-penulis').textContent = `Penulis: ${data.buku.penulis}`;
            document.getElementById('detail-member').textContent = data.member.nama;
            document.getElementById('detail-email').textContent = data.member.email;
            document.getElementById('detail-pinjam').textContent = `Pinjam: ${new Date(data.tanggal_peminjaman).toLocaleDateString('id-ID')}`;
            document.getElementById('detail-kembali').textContent = `Harus Kembali: ${new Date(data.tanggal_pengembalian).toLocaleDateString('id-ID')}`;
            document.getElementById('detail-status').textContent = `Status: ${data.status}`;
            
            const today = new Date(tanggalKembaliInput.value);
            const batasKembali = new Date(data.tanggal_pengembalian);
            const selisihHari = Math.ceil((today - batasKembali) / (1000 * 60 * 60 * 24));
            
            if (selisihHari > 0) {
                const denda = selisihHari * 5000;
                document.getElementById('detail-terlambat').textContent = `Terlambat: ${selisihHari} hari (Denda: Rp ${denda.toLocaleString('id-ID')})`;
                dendaInput.value = denda;
            } else {
                document.getElementById('detail-terlambat').textContent = 'Tidak terlambat';
                dendaInput.value = 0;
            }
            
            peminjamanDetail.classList.remove('hidden');
        } else {
            peminjamanDetail.classList.add('hidden');
            dendaInput.value = 0;
        }
    });

    tanggalKembaliInput.addEventListener('change', function() {
        const peminjamanId = peminjamanSelect.value;
        if (peminjamanId && peminjamanData[peminjamanId]) {
            const data = peminjamanData[peminjamanId];
            const today = new Date(this.value);
            const batasKembali = new Date(data.tanggal_pengembalian);
            const selisihHari = Math.ceil((today - batasKembali) / (1000 * 60 * 60 * 24));
            
            if (selisihHari > 0) {
                const denda = selisihHari * 5000;
                document.getElementById('detail-terlambat').textContent = `Terlambat: ${selisihHari} hari (Denda: Rp ${denda.toLocaleString('id-ID')})`;
                dendaInput.value = denda;
            } else {
                document.getElementById('detail-terlambat').textContent = 'Tidak terlambat';
                dendaInput.value = 0;
            }
        }
    });

    if (peminjamanSelect.value) {
        peminjamanSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection
@endsection
