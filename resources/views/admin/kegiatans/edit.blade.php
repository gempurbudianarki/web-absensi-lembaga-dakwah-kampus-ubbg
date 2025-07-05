@extends('layouts.admin')

@push('styles')
{{-- Menambahkan CSS untuk Flatpickr dan Cropper.js dari CDN --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
<style>
    .form-group label { font-weight: 600; }
    .card-header h6 { font-size: 1rem; }
    .preview-container {
        margin-top: 1rem; border: 2px dashed #e3e6f0; padding: 1rem;
        border-radius: .35rem; display: flex; align-items: center;
        justify-content: center; min-height: 200px; background-color: #f8f9fc;
        position: relative; overflow: hidden;
    }
    .preview-container img { max-width: 100%; max-height: 250px; }
    
    /* KUNCI PERBAIKAN TAMPILAN CROPPER */
    #cropper-container {
        width: 100%;
        height: 400px; /* Memberikan tinggi yang pasti untuk area kerja */
    }
    #cropper-image {
        display: block;
        max-width: 100%; /* Memastikan gambar tidak meluap keluar dari container */
    }
    
    /* Style untuk tombol "Sekarang" agar menyatu dengan input */
    .input-group-append .btn {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Kegiatan: {{ $kegiatan->nama_kegiatan }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form action="{{ route('admin.kegiatans.update', $kegiatan->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        {{-- Card Informasi Utama --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-info-circle mr-2"></i>Informasi Utama</h6></div>
            <div class="card-body">
                <div class="form-group">
                    <label for="nama_kegiatan">Nama Kegiatan</label>
                    <input type="text" class="form-control" name="nama_kegiatan" value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}" required>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" rows="4">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" class="form-control" name="lokasi" value="{{ old('lokasi', $kegiatan->lokasi) }}" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="kode_absensi">Kode Absensi (Manual)</label>
                        <input type="text" class="form-control" name="kode_absensi" value="{{ old('kode_absensi', $kegiatan->kode_absensi) }}" required>
                    </div>
                </div>
            </div>
        </div>

        {{-- Jadwal Kegiatan & Absensi --}}
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-calendar-alt mr-2"></i>Jadwal Acara</h6></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="tanggal">Tanggal Acara</label>
                            <input type="text" class="form-control date-picker" name="tanggal" value="{{ old('tanggal', $kegiatan->tanggal->format('Y-m-d')) }}" required>
                        </div>
                        <div class="row">
                            <div class="col-6 form-group">
                                <label for="waktu_mulai">Waktu Mulai</label>
                                <input type="text" class="form-control time-picker" name="waktu_mulai" value="{{ old('waktu_mulai', $kegiatan->waktu_mulai->format('H:i')) }}" required>
                            </div>
                            <div class="col-6 form-group">
                                <label for="waktu_selesai">Waktu Selesai</label>
                                <input type="text" class="form-control time-picker" name="waktu_selesai" value="{{ old('waktu_selesai', $kegiatan->waktu_selesai->format('H:i')) }}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-clock mr-2"></i>Jendela Waktu Absensi</h6></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="absensi_mulai">Absensi Dibuka</label>
                            <div class="input-group">
                                <input type="text" class="form-control datetime-picker" id="absensi_mulai" name="absensi_mulai" value="{{ old('absensi_mulai', $kegiatan->absensi_mulai ? $kegiatan->absensi_mulai->format('Y-m-d H:i') : '') }}" required>
                                <div class="input-group-append"><button class="btn btn-outline-secondary set-now" type="button" data-target="#absensi_mulai" title="Set Waktu Sekarang">Sekarang</button></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="absensi_selesai">Absensi Ditutup</label>
                            <div class="input-group">
                                <input type="text" class="form-control datetime-picker" id="absensi_selesai" name="absensi_selesai" value="{{ old('absensi_selesai', $kegiatan->absensi_selesai ? $kegiatan->absensi_selesai->format('Y-m-d H:i') : '') }}" required>
                                <div class="input-group-append"><button class="btn btn-outline-secondary set-now" type="button" data-target="#absensi_selesai" title="Set Waktu Sekarang">Sekarang</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Poster Kegiatan --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-image mr-2"></i>Poster Kegiatan</h6></div>
            <div class="card-body">
                <div class="form-group">
                    <label>Poster Saat Ini:</label>
                    <div class="preview-container mb-3">
                        <img src="{{ $kegiatan->poster ? asset('storage/' . $kegiatan->poster) : 'https://placehold.co/800x600/6c757d/FFFFFF?text=No+Image' }}" alt="Poster Saat Ini" id="current-poster">
                    </div>
                </div>
                <div class="form-group">
                    <label for="poster-input">Ganti Poster (Opsional)</label>
                    <input type="file" class="form-control-file" id="poster-input" accept="image/*">
                    <input type="hidden" name="poster_base64" id="poster_base64">
                    <small class="form-text text-muted">Pilih gambar baru jika ingin mengganti poster di atas.</small>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-lg shadow-sm"><i class="fas fa-sync-alt mr-2"></i>Update Kegiatan</button>
        <a href="{{ route('admin.kegiatans.index') }}" class="btn btn-secondary btn-lg shadow-sm">Batal</a>
    </form>
    
    <!-- KODE HTML MODAL YANG LENGKAP -->
    <div class="modal fade" id="cropper-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">Sesuaikan Ukuran Poster</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="alert alert-info"><i class="fas fa-mouse-pointer mr-2"></i>Gunakan scroll mouse untuk zoom dan geser gambar untuk mendapatkan hasil terbaik.</div>
            <div id="cropper-container">
                <img id="cropper-image" src="">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info" id="reset-crop-button"><i class="fas fa-sync-alt mr-2"></i>Reset</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" id="crop-button"><i class="fas fa-cut mr-2"></i>Potong & Simpan</button>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- KODE JAVASCRIPT YANG LENGKAP --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi Flatpickr
    flatpickr(".datetime-picker", { enableTime: true, dateFormat: "Y-m-d H:i", time_24hr: true });
    flatpickr(".date-picker", { dateFormat: "Y-m-d" });
    flatpickr(".time-picker", { enableTime: true, noCalendar: true, dateFormat: "H:i", time_24hr: true });

    // Fungsi Tombol "Set Waktu Sekarang"
    document.querySelectorAll('.set-now').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.dataset.target;
            const targetInput = document.querySelector(targetId);
            if (targetInput && targetInput._flatpickr) {
                targetInput._flatpickr.setDate(new Date(), true);
            }
        });
    });

    // Fungsi Cropper yang Lengkap
    const imageInput = document.getElementById('poster-input');
    const cropperImage = document.getElementById('cropper-image');
    const cropperModal = $('#cropper-modal');
    const hiddenInput = document.getElementById('poster_base64');
    const previewContainer = document.querySelector('.preview-container');

    imageInput.addEventListener('change', function(e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            const reader = new FileReader();
            reader.onload = function(event) {
                cropperImage.src = event.target.result;
                cropperModal.modal('show');
            };
            reader.readAsDataURL(files[0]);
        }
    });

    cropperModal.on('shown.bs.modal', function () {
        if (cropper) {
            cropper.destroy();
        }
        cropper = new Cropper(cropperImage, {
            aspectRatio: 4 / 3,
            viewMode: 1,
            dragMode: 'move',
            background: false,
            autoCropArea: 0.8,
            responsive: true,
        });
    });

    document.getElementById('reset-crop-button').addEventListener('click', function() {
        if(cropper) {
            cropper.reset();
        }
    });

    document.getElementById('crop-button').addEventListener('click', function() {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas({ width: 800, height: 600, imageSmoothingQuality: 'high' });
            // Ganti pratinjau di halaman utama
            const currentPoster = document.getElementById('current-poster');
            if(currentPoster) {
                currentPoster.src = canvas.toDataURL('image/jpeg');
            } else {
                 previewContainer.innerHTML = `<img src="${canvas.toDataURL('image/jpeg')}" alt="Pratinjau Poster Baru" id="current-poster">`;
            }
            hiddenInput.value = canvas.toDataURL('image/jpeg');
            cropperModal.modal('hide');
        }
    });
});
</script>
@endpush
