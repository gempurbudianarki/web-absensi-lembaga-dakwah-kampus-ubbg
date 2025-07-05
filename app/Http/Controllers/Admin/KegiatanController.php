<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    /**
     * Menampilkan daftar semua kegiatan.
     */
    public function index()
    {
        $kegiatans = Kegiatan::orderBy('tanggal_kegiatan', 'desc')->get();
        return view('admin.kegiatans.index', compact('kegiatans'));
    }

    /**
     * Menampilkan form untuk membuat kegiatan baru.
     */
    public function create()
    {
        return view('admin.kegiatans.create');
    }

    /**
     * Menyimpan kegiatan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tanggal_kegiatan' => 'required|date',
            'waktu_mulai_absen' => 'required|date',
            'waktu_selesai_absen' => 'required|date|after:waktu_mulai_absen',
        ]);

        $data = $request->all();

        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('posters', 'public');
            $data['poster'] = $path;
        }

        if (empty($data['kode_absensi'])) {
            $data['kode_absensi'] = strtoupper(Str::slug(substr($data['nama_kegiatan'], 0, 6), '')) . '-' . strtoupper(Str::random(6));
        }

        Kegiatan::create($data);

        return redirect()->route('admin.kegiatans.index')->with('success', 'Kegiatan baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit kegiatan.
     */
    public function edit(Kegiatan $kegiatan)
    {
        return view('admin.kegiatans.edit', compact('kegiatan'));
    }

    /**
     * Memperbarui data kegiatan di database.
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tanggal_kegiatan' => 'required|date',
            'waktu_mulai_absen' => 'required|date',
            'waktu_selesai_absen' => 'required|date|after:waktu_mulai_absen',
        ]);

        $data = $request->all();

        if ($request->hasFile('poster')) {
            if ($kegiatan->poster) {
                Storage::disk('public')->delete($kegiatan->poster);
            }
            $path = $request->file('poster')->store('posters', 'public');
            $data['poster'] = $path;
        }

        if (empty($data['kode_absensi'])) {
            $data['kode_absensi'] = strtoupper(Str::slug(substr($data['nama_kegiatan'], 0, 6), '')) . '-' . strtoupper(Str::random(6));
        }

        $kegiatan->update($data);

        return redirect()->route('admin.kegiatans.index')->with('success', 'Data kegiatan berhasil diperbarui!');
    }

    /**
     * Menghapus kegiatan dari database.
     */
    public function destroy(Kegiatan $kegiatan)
    {
        // [MODIFIKASI KITA] Logika untuk menghapus kegiatan dan posternya
        
        // 1. Cek apakah kegiatan ini punya poster
        if ($kegiatan->poster) {
            // Jika ada, hapus file posternya dari storage
            Storage::disk('public')->delete($kegiatan->poster);
        }

        // 2. Hapus data kegiatan dari database
        $kegiatan->delete();

        // 3. Arahkan kembali ke halaman daftar kegiatan dengan pesan sukses
        return redirect()->route('admin.kegiatans.index')->with('success', 'Kegiatan berhasil dihapus!');
    }
}
