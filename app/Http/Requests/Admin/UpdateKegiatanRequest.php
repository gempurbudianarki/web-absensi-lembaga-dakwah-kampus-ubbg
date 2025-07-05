<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKegiatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $kegiatanId = $this->route('kegiatan')->id;

        return [
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
            'lokasi'        => 'required|string|max:255',
            'tanggal'       => 'required|date_format:Y-m-d',
            'waktu_mulai'   => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'absensi_mulai'   => 'required|date',
            'absensi_selesai' => 'required|date|after:absensi_mulai',
            'poster_base64' => 'nullable|string',
            'kode_absensi'  => ['required', 'string', 'max:50', Rule::unique('kegiatans')->ignore($kegiatanId)],
        ];
    }
}
