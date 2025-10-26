@extends('layouts.admin')

@section('title', 'Tambah Peminjaman')

@section('content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Tambah Peminjaman Baru</h2>
        <a href="{{ route('admin.peminjaman.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm">
        <form action="{{ route('admin.peminjaman.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Data Buku -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Data Buku</h3>
                    <div class="mb-4">
                        <label for="buku_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Buku *</label>
                        <select name="buku_id" id="buku_id" required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Buku --</option>
                            @foreach($bukus as $buku)
                                <option value="{{ $buku->id }}" data-stok="{{ $buku->stok }}" 
                                        {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                                    {{ $buku->judul }} (Stok: {{ $buku->stok }})
                                </option>
                            @endforeach
                        </select>
                        <div id="stok-info" class="text-sm text-gray-500 mt-1"></div>
                    </div>

                    <div id="buku-detail" class="hidden p-4 bg-gray-50 border rounded-lg">
                        <h4 class="font-medium mb-2">Detail Buku:</h4>
                        <div id="detail-content"></div>
                    </div>
                </div>

                <!-- Data Member -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Data Member</h3>
                    <div class="mb-4">
                        <label for="member_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Member *</label>
                        <select name="member_id" id="member_id" required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Member --</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->nama }} - {{ $member->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="member-detail" class="hidden p-4 bg-gray-50 border rounded-lg">
                        <h4 class="font-medium mb-2">Detail Member:</h4>
                        <div id="member-content"></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <div>
                    <label for="tanggal_peminjaman" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Peminjaman *
                    </label>
                    <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman" 
                           value="{{ old('tanggal_peminjaman', date('Y-m-d')) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="tanggal_pengembalian" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Pengembalian *
                    </label>
                    <input type="date" name="tanggal_pengembalian" id="tanggal_pengembalian" 
                           value="{{ old('tanggal_pengembalian') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="mt-6">
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex justify-end space-x-3 mt-8">
                <a href="{{ route('admin.peminjaman.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition flex items-center">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
                <button type="submit" class="btn-primary text-white px-6 py-3 rounded-lg font-medium transition flex items-center">
                    <i class="fas fa-save mr-2"></i> Simpan Peminjaman
                </button>
            </div>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bukuSelect = document.getElementById('buku_id');
    const stokInfo = document.getElementById('stok-info');
    const bukuDetail = document.getElementById('buku-detail');
    const detailContent = document.getElementById('detail-content');
    const memberSelect = document.getElementById('member_id');
    const memberDetail = document.getElementById('member-detail');
    const memberContent = document.getElementById('member-content');
    const members = @json($members->keyBy('id'));

    // Menampilkan detail buku
    bukuSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const stok = selectedOption.getAttribute('data-stok');
        
        if (this.value) {
            stokInfo.textContent = `Stok tersedia: ${stok}`;
            stokInfo.className = stok == 0 
                ? 'text-sm text-red-600 mt-1' 
                : 'text-sm text-green-600 mt-1';

            const bukuId = this.value;
            fetch(`/admin/buku/${bukuId}`)
                .then(response => response.json())
                .then(data => {
                    detailContent.innerHTML = `
                        <p><strong>Penulis:</strong> ${data.penulis}</p>
                        <p><strong>Penerbit:</strong> ${data.penerbit}</p>
                        <p><strong>Tahun:</strong> ${data.tahun_terbit}</p>
                        <p><strong>Kategori:</strong> ${data.kategori.nama_kategori}</p>
                    `;
                    bukuDetail.classList.remove('hidden');
                });
        } else {
            stokInfo.textContent = '';
            bukuDetail.classList.add('hidden');
        }
    });

    // Menampilkan detail member
    memberSelect.addEventListener('change', function() {
        if (this.value) {
            const member = members[this.value];
            memberContent.innerHTML = `
                <p><strong>Email:</strong> ${member.email}</p>
                <p><strong>No. HP:</strong> ${member.no_hp}</p>
                <p><strong>Alamat:</strong> ${member.alamat}</p>
            `;
            memberDetail.classList.remove('hidden');
        } else {
            memberDetail.classList.add('hidden');
        }
    });

    // Validasi tanggal
    const tanggalPinjam = document.getElementById('tanggal_peminjaman');
    const tanggalKembali = document.getElementById('tanggal_pengembalian');
    tanggalPinjam.addEventListener('change', function() {
        tanggalKembali.min = this.value;
        if (tanggalKembali.value && tanggalKembali.value < this.value) {
            tanggalKembali.value = this.value;
        }
    });
});
</script>
@endsection
@endsection
