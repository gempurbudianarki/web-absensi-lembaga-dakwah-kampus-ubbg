<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    /**
     * Menampilkan halaman untuk melakukan absensi.
     */
    public function show(Kegiatan $kegiatan)
    {
        $userId = Auth::id();

        $sudahAbsen = Absensi::where('user_id', $userId)
                             ->where('kegiatan_id', $kegiatan->id)
                             ->exists();

        $sekarang = now();
        $statusAbsen = 'DITUTUP';

        if ($sekarang->between($kegiatan->waktu_mulai_absen, $kegiatan->waktu_selesai_absen)) {
            $statusAbsen = 'DIBUKA';
        } elseif ($sekarang < $kegiatan->waktu_mulai_absen) {
            $statusAbsen = 'BELUM DIBUKA';
        }

        return view('anggota.absensi.show', compact('kegiatan', 'sudahAbsen', 'statusAbsen'));
    }

    /**
     * Menyimpan data absensi baru.
     */
    public function store(Request $request)
    {
        // [MODIFIKASI KITA] Logika untuk memproses absensi

        // 1. Validasi input
        $request->validate([
            'kegiatan_id' => 'required|exists:kegiatans,id',
            'kode_absensi' => 'required|string',
        ]);

        // 2. Ambil data yang dibutuhkan
        $kegiatan = Kegiatan::find($request->kegiatan_id);
        $userId = Auth::id();

        // 3. Lakukan serangkaian pengecekan keamanan
        
        // Cek #1: Apakah kode absensi yang dimasukkan cocok dengan di database?
        if ($kegiatan->kode_absensi !== $request->kode_absensi) {
            // Jika tidak cocok, kembalikan dengan pesan error
            return redirect()->back()->with('error', 'Kode absensi yang Anda masukkan salah!');
        }

        // Cek #2: Apakah waktu absensi masih dibuka?
        $sekarang = now();
        if (!$sekarang->between($kegiatan->waktu_mulai_absen, $kegiatan->waktu_selesai_absen)) {
            return redirect()->back()->with('error', 'Maaf, waktu absensi sudah ditutup.');
        }

        // Cek #3: Apakah user sudah pernah absen? (Pengecekan ulang di sisi server)
        $sudahAbsen = Absensi::where('user_id', $userId)->where('kegiatan_id', $kegiatan->id)->exists();
        if ($sudahAbsen) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absensi untuk kegiatan ini.');
        }

        // 4. Jika semua pengecekan lolos, simpan data absensi
        Absensi::create([
            'user_id' => $userId,
            'kegiatan_id' => $kegiatan->id,
            'status' => 'Hadir', // Default status saat absen mandiri adalah 'Hadir'
        ]);

        // 5. Arahkan kembali ke dashboard anggota dengan pesan sukses
        return redirect()->route('anggota.dashboard')->with('success', 'Absensi untuk kegiatan "' . $kegiatan->nama_kegiatan . '" berhasil dicatat. Terima kasih!');
    }
}
