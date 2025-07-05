<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // Mendapatkan ID pengguna dari parameter rute (misal: /users/{user})
        $userId = $this->route('user')->id;

        return [
            'name'      => 'required|string|max:255',
            // Saat update, validasi 'unique' harus mengabaikan data milik pengguna itu sendiri.
            'nim'       => ['required', 'string', 'max:20', Rule::unique('users')->ignore($userId)],
            'email'     => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            // Password bersifat opsional saat update. Hanya divalidasi jika diisi.
            'password'  => 'nullable|string|min:8|confirmed',
            'role'      => 'required|in:admin,ketua,pengurus,anggota',
            'divisi_id' => 'nullable|exists:divisis,id',
        ];
    }
}
