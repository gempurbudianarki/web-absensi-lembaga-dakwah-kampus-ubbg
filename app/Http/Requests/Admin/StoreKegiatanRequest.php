<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreKegiatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
            'lokasi'        => 'required|string|max:255',
            
            // Validasi untuk Jadwal Kegiatan
            'tanggal'       => 'required|date_format:Y-m-d',
            'waktu_mulai'   => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            
            // Validasi untuk Jadwal Absensi
            'absensi_mulai'   => 'required|date',
            'absensi_selesai' => 'required|date|after:absensi_mulai',
            
            'poster_base64' => 'nullable|string',
            'kode_absensi'  => 'required|string|max:50|unique:kegiatans,kode_absensi',
        ];
    }
}
