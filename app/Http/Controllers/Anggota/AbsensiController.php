<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Http\Requests\Anggota\StoreAbsensiRequest;
use App\Models\Kegiatan;
use App\Services\AbsensiService; // <-- Panggil Service kita
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    protected $absensiService;

    // Menggunakan Dependency Injection untuk memasukkan AbsensiService
    public function __construct(AbsensiService $absensiService)
    {
        $this->absensiService = $absensiService;
    }

    /**
     * Menyimpan data absensi baru.
     */
    public function store(StoreAbsensiRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        
        $kegiatan = Kegiatan::findOrFail($validated['kegiatan_id']);
        $user = Auth::user();

        // Panggil service untuk memproses logika absensi
        $result = $this->absensiService->processAbsensi(
            $kegiatan,
            $user,
            $validated['kode_absensi']
        );

        // Redirect kembali dengan pesan dari service
        return back()->with($result['status'], $result['message']);
    }
}
