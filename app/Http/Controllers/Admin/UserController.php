<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Divisi;
use App\Http\Requests\Admin\StoreUserRequest;   // <-- Panggil StoreUserRequest
use App\Http\Requests\Admin\UpdateUserRequest;  // <-- Panggil UpdateUserRequest
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna.
     */
    public function index(): View
    {
        $users = User::with('divisi')->latest()->paginate(10); // Gunakan paginate untuk data yang banyak
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat pengguna baru.
     */
    public function create(): View
    {
        $divisis = Divisi::all();
        return view('admin.users.create', compact('divisis'));
    }

    /**
     * Menyimpan pengguna baru ke dalam database.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        // Validasi sudah otomatis dijalankan oleh StoreUserRequest.
        // Jika gagal, akan otomatis redirect kembali dengan pesan error.
        $validatedData = $request->validated();

        User::create([
            'name' => $validatedData['name'],
            'nim' => $validatedData['nim'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
            'divisi_id' => $validatedData['divisi_id'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail spesifik dari seorang pengguna.
     * (Method ini tidak digunakan jika Anda tidak memiliki halaman detail, tapi ini adalah standar resource controller)
     */
    public function show(User $user): View
    {
        // Biasanya untuk menampilkan halaman detail user, jika diperlukan.
        return view('admin.users.show', compact('user'));
    }


    /**
     * Menampilkan form untuk mengedit pengguna.
     */
    public function edit(User $user): View
    {
        $divisis = Divisi::all();
        return view('admin.users.edit', compact('user', 'divisis'));
    }

    /**
     * Memperbarui data pengguna di dalam database.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        // Validasi otomatis dijalankan oleh UpdateUserRequest.
        $validatedData = $request->validated();

        // Cek apakah password diisi atau tidak
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            // Jika password tidak diisi, hapus dari array agar tidak menimpa password lama
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna dari database.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Tambahkan logika untuk memastikan admin tidak bisa menghapus dirinya sendiri
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
