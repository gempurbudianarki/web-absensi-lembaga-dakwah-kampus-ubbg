<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    /**
     * Menampilkan halaman daftar agenda kegiatan.
     */
    public function index()
    {
        $userId = Auth::id();
        $semua_kegiatan = Kegiatan::with(['absensi' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])
            ->orderBy('waktu_mulai', 'desc')
            ->paginate(9);

        return view('anggota.agenda.index', [
            'kegiatans' => $semua_kegiatan
        ]);
    }

    /**
     * Mengambil dan mengembalikan detail satu kegiatan spesifik dalam format JSON.
     */
    public function show(Kegiatan $kegiatan)
    {
        return response()->json([
            'id' => $kegiatan->id,
            'nama_kegiatan' => $kegiatan->nama_kegiatan,
            'deskripsi' => $kegiatan->deskripsi,
            'lokasi' => $kegiatan->lokasi,
            'poster_url' => $kegiatan->poster_url,
            'waktu_mulai_formatted' => $kegiatan->waktu_mulai->isoFormat('dddd, D MMMM Y'),
            'waktu_selesai_formatted' => $kegiatan->waktu_selesai->isoFormat('H:i \W\I\B'),
        ]);
    }

    /**
     * FUNGSI BARU UNTUK MENYIMPAN ABSENSI
     * Memvalidasi dan menyimpan data kehadiran baru dari anggota.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeAbsensi(Kegiatan $kegiatan)
    {
        $user = Auth::user();
        $now = now();

        // 1. Validasi: Cek apakah waktu absensi sedang dibuka
        if (!$now->isBetween($kegiatan->waktu_mulai_absensi, $kegiatan->waktu_selesai_absensi)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Maaf, waktu absensi untuk kegiatan ini sudah ditutup atau belum dibuka.'
            ], 403); // 403 Forbidden
        }

        // 2. Validasi: Cek apakah user sudah pernah absen di kegiatan ini
        $sudahAbsen = Absensi::where('user_id', $user->id)
                             ->where('kegiatan_id', $kegiatan->id)
                             ->exists();

        if ($sudahAbsen) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah tercatat hadir pada kegiatan ini.'
            ], 409); // 409 Conflict
        }

        // 3. Jika semua validasi lolos, simpan data absensi
        try {
            Absensi::create([
                'user_id' => $user->id,
                'kegiatan_id' => $kegiatan->id,
                'waktu_absensi' => $now,
                'status' => 'hadir', // Status default saat absen
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Alhamdulillah, kehadiran Anda berhasil dicatat!'
            ], 201); // 201 Created

        } catch (\Exception $e) {
            // Tangani jika ada error tak terduga saat menyimpan ke database
            report($e); // Laporkan error ke log
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan pada server. Silakan coba lagi.'
            ], 500); // 500 Internal Server Error
        }
    }
}
