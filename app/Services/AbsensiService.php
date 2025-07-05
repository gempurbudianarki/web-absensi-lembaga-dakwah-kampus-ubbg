<?php

namespace App\Services;

use App\Models\Kegiatan;
use App\Models\User;
use Carbon\Carbon;

class AbsensiService
{
    /**
     * Memproses permintaan absensi dari seorang pengguna untuk sebuah kegiatan.
     *
     * @param Kegiatan $kegiatan
     * @param User $user
     * @param string $kode_absensi
     * @return array ['status' => 'success'|'error', 'message' => string]
     */
    public function processAbsensi(Kegiatan $kegiatan, User $user, string $kode_absensi): array
    {
        // 1. Cek apakah kode absensi yang dimasukkan cocok
        if ($kegiatan->kode_absensi !== $kode_absensi) {
            return ['status' => 'error', 'message' => 'Kode absensi yang Anda masukkan salah.'];
        }

        // 2. Cek apakah pengguna sudah pernah absen di kegiatan ini
        $sudahAbsen = $kegiatan->absensis()->where('user_id', $user->id)->exists();
        if ($sudahAbsen) {
            return ['status' => 'error', 'message' => 'Anda sudah melakukan absensi untuk kegiatan ini.'];
        }

        // 3. Cek apakah waktu absensi masih dibuka
        $now = Carbon::now();
        $waktuMulai = Carbon::parse($kegiatan->tanggal->format('Y-m-d') . ' ' . $kegiatan->waktu_mulai->format('H:i:s'));
        $waktuSelesai = Carbon::parse($kegiatan->tanggal->format('Y-m-d') . ' ' . $kegiatan->waktu_selesai->format('H:i:s'));

        if (!$now->between($waktuMulai, $waktuSelesai)) {
            return ['status' => 'error', 'message' => 'Absensi untuk kegiatan ini belum dibuka atau sudah ditutup.'];
        }

        // 4. Jika semua pengecekan lolos, simpan absensi
        $kegiatan->absensis()->create([
            'user_id' => $user->id,
        ]);

        return ['status' => 'success', 'message' => 'Absensi berhasil! Terima kasih atas kehadiran Anda.'];
    }
}
