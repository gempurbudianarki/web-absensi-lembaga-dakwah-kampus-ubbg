@extends('layouts.anggota')

@push('styles')
{{-- CSS Kustom untuk Desain Baru Halaman Agenda --}}
<style>
    /* Keyframes untuk animasi */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Desain Kartu Kegiatan v3 */
    .kegiatan-card-v3 {
        background-color: #fff;
        border-radius: 16px;
        border: 1px solid #e9ecef;
        transition: all 0.35s ease;
        cursor: pointer;
        animation: fadeIn 0.5s ease-out forwards;
        opacity: 0;
    }
    .kegiatan-card-v3:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 32px rgba(44, 62, 80, 0.15) !important;
        border-color: #3498db;
    }
    .kegiatan-card-v3 .poster-wrapper {
        height: 200px;
        background-color: #f8f9fa; /* Warna latar jika gambar tidak penuh */
        padding: 10px;
        border-radius: 16px 16px 0 0;
    }
    .kegiatan-card-v3 .poster-image {
        width: 100%;
        height: 100%;
        object-fit: contain; /* KUNCI: Menampilkan seluruh gambar tanpa memotong */
    }
    .kegiatan-card-v3 .card-body {
        padding: 1.25rem;
    }
    .kegiatan-card-v3 .card-title {
        font-weight: 700;
        color: #2c3e50;
        line-height: 1.4;
        min-height: 2.8em; /* Cukup untuk 2 baris */
        margin-bottom: 1rem;
    }
    .kegiatan-card-v3 .info-item {
        font-size: 0.9rem;
        color: #7f8c8d;
    }
    .kegiatan-card-v3 .info-item i {
        color: #95a5a6;
    }

    /* Desain Modal Detail v3 (Profesional) */
    .modal-content-v3 {
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 50px rgba(0,0,0,0.2);
    }
    .modal-header-v3 {
        border-bottom: 0;
        padding: 1.5rem 1.5rem 0.5rem 1.5rem;
    }
    .modal-title-v3 {
        font-weight: 700;
        color: #2c3e50;
    }
    .modal-body-v3 {
        padding: 0.5rem 1.5rem 1.5rem 1.5rem;
    }
    .modal-poster-frame {
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        background-color: #f0f2f5;
        /* Bingkai Islami Halus menggunakan SVG */
        background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23dce4e9' fill-opacity='0.6'%3E%3Cpath d='M50 50h10v10H50zM10 10h10v10H10zM30 30h10v10H30z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .modal-poster-image {
        width: 100%;
        max-height: 400px; /* Batas tinggi maksimal */
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .modal-detail-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1rem;
        font-size: 1rem;
    }
    .modal-detail-item i {
        font-size: 1.2rem;
        color: #3498db;
        margin-right: 15px;
        margin-top: 3px;
        width: 24px;
        text-align: center;
    }
    .modal-detail-item .detail-label {
        font-weight: 600;
        color: #34495e;
        display: block;
        margin-bottom: 2px;
    }
    .modal-detail-item .detail-value {
        color: #7f8c8d;
    }
    .modal-footer-v3 {
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
        border-radius: 0 0 20px 20px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 fw-bold text-dark">Agenda Kegiatan</h3>
    </div>

    <div class="row">
        @forelse ($kegiatans as $index => $kegiatan)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card kegiatan-card-v3 shadow-sm" style="animation-delay: {{ $index * 120 }}ms;"
                     data-bs-toggle="modal" data-bs-target="#kegiatanDetailModal" 
                     data-id="{{ $kegiatan->id }}">
                    <div class="poster-wrapper">
                        <img src="{{ $kegiatan->poster_url }}" class="poster-image" alt="Poster {{ $kegiatan->nama_kegiatan }}">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $kegiatan->nama_kegiatan }}</h5>
                        <div class="info-item mb-2">
                            <i class="fas fa-calendar-alt fa-fw me-2"></i>
                            <span>{{ $kegiatan->waktu_mulai->isoFormat('dddd, D MMMM Y') }}</span>
                        </div>
                        <hr class="my-3">
                        @php
                            $now = now();
                            $absensiUser = $kegiatan->absensi->first();
                            $isAbsenOpen = $now->isBetween($kegiatan->waktu_mulai_absensi, $kegiatan->waktu_selesai_absensi);
                            $status = '';
                            $badgeClass = '';
                            if ($absensiUser) { $status = 'Telah Hadir'; $badgeClass = 'bg-success'; } 
                            elseif ($isAbsenOpen) { $status = 'Absensi Dibuka'; $badgeClass = 'bg-danger'; } 
                            elseif ($now->isAfter($kegiatan->waktu_selesai_absensi)) { $status = 'Selesai'; $badgeClass = 'bg-secondary'; } 
                            else { $status = 'Akan Datang'; $badgeClass = 'bg-info'; }
                        @endphp
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge rounded-pill {{ $badgeClass }}">{{ $status }}</span>
                            <span class="text-primary fw-bold">Lihat Detail <i class="fas fa-arrow-right ms-1"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center p-5">
                <img src="https://placehold.co/200x200/e9ecef/7f8c8d?text=Kosong" class="mb-4" style="border-radius: 50%;" alt="Tidak ada agenda">
                <h4 class="text-muted">Belum Ada Agenda</h4>
                <p class="text-muted">Saat ini belum ada kegiatan yang dijadwalkan.</p>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $kegiatans->links() }}
    </div>
</div>

<!-- Modal Detail Kegiatan (Desain Baru) -->
<div class="modal fade" id="kegiatanDetailModal" tabindex="-1" aria-labelledby="kegiatanDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-v3">
            <div class="modal-header modal-header-v3">
                <h5 class="modal-title modal-title-v3" id="kegiatanDetailModalLabel">Detail Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-body-v3" id="modal-body-content">
                {{-- Konten diisi oleh JavaScript --}}
            </div>
            <div class="modal-footer modal-footer-v3">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" id="btn-absen-modal" data-kegiatan-id="">
                    <i class="fas fa-check-circle me-2"></i>Lakukan Absensi
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const kegiatanDetailModal = document.getElementById('kegiatanDetailModal');
    const modalBody = document.getElementById('modal-body-content');
    const modalTitle = document.getElementById('kegiatanDetailModalLabel');
    const btnAbsen = document.getElementById('btn-absen-modal');
    
    kegiatanDetailModal.addEventListener('show.bs.modal', async function (event) {
        const triggerElement = event.relatedTarget;
        const kegiatanId = triggerElement.dataset.id;
        
        btnAbsen.dataset.kegiatanId = kegiatanId;
        modalBody.innerHTML = `<div class="text-center p-5"><div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-3 text-muted">Memuat detail kegiatan...</p></div>`;
        modalTitle.innerText = 'Memuat...';
        btnAbsen.disabled = true;

        try {
            const response = await fetch(`/api/kegiatan/${kegiatanId}`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (!response.ok) throw new Error('Gagal memuat data.');
            const data = await response.json();

            modalTitle.innerText = data.nama_kegiatan;
            modalBody.innerHTML = `
                <div class="modal-poster-frame">
                    <img src="${data.poster_url}" class="modal-poster-image" alt="Poster ${data.nama_kegiatan}">
                </div>
                <div class="modal-detail-item">
                    <i class="fas fa-info-circle fa-fw"></i>
                    <div>
                        <span class="detail-label">Deskripsi</span>
                        <span class="detail-value">${data.deskripsi || 'Tidak ada deskripsi.'}</span>
                    </div>
                </div>
                <div class="modal-detail-item">
                    <i class="fas fa-calendar-day fa-fw"></i>
                    <div>
                        <span class="detail-label">Tanggal & Waktu</span>
                        <span class="detail-value">${data.waktu_mulai_formatted} - ${data.waktu_selesai_formatted}</span>
                    </div>
                </div>
                <div class="modal-detail-item">
                    <i class="fas fa-map-marker-alt fa-fw"></i>
                    <div>
                        <span class="detail-label">Lokasi</span>
                        <span class="detail-value">${data.lokasi}</span>
                    </div>
                </div>
            `;
            
            btnAbsen.disabled = false;

        } catch (error) {
            modalTitle.innerText = 'Error';
            modalBody.innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
        }
    });

    btnAbsen.addEventListener('click', async function() {
        const kegiatanId = this.dataset.kegiatanId;
        this.disabled = true;
        this.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...`;

        try {
            const response = await fetch(`/api/kegiatan/${kegiatanId}/absensi`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            const result = await response.json();
            if (!response.ok) throw new Error(result.message || 'Respon server tidak valid.');

            Swal.fire({
                icon: 'success', title: 'Berhasil!', text: result.message,
                timer: 2000, showConfirmButton: false,
                willClose: () => { window.location.reload(); }
            });

        } catch (error) {
            Swal.fire({ icon: 'error', title: 'Gagal', text: error.message });
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-check-circle me-2"></i>Lakukan Absensi';
        }
    });
});
</script>
@endpush
