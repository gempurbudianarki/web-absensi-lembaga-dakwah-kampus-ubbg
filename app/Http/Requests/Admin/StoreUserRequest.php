<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'nim'       => 'required|string|max:20|unique:users,nim',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'password'  => 'required|string|min:8|confirmed',
            // PERBARUI DAFTAR ROLE DI SINI
            'role'      => 'required|in:admin,ketua,wakil ketua,sekretaris,bendahara,pengurus,anggota',
            'divisi_id' => 'nullable|exists:divisis,id',
        ];
    }
}
