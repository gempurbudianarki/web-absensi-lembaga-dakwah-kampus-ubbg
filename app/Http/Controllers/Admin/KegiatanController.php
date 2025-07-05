<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Http\Requests\Admin\StoreKegiatanRequest;
use App\Http\Requests\Admin\UpdateKegiatanRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Str;

class KegiatanController extends Controller
{
    public function index(): View
    {
        $kegiatans = Kegiatan::latest()->paginate(10);
        return view('admin.kegiatans.index', compact('kegiatans'));
    }

    public function create(): View
    {
        return view('admin.kegiatans.create');
    }

    public function store(StoreKegiatanRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        if ($request->filled('poster_base64')) {
            $validatedData['poster'] = $this->saveBase64Image($request->input('poster_base64'));
        }
        Kegiatan::create($validatedData);
        return redirect()->route('admin.kegiatans.index')->with('success', 'Kegiatan baru berhasil dibuat!');
    }

    public function edit(Kegiatan $kegiatan): View
    {
        return view('admin.kegiatans.edit', compact('kegiatan'));
    }

    public function update(UpdateKegiatanRequest $request, Kegiatan $kegiatan): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->filled('poster_base64')) {
            if ($kegiatan->poster) {
                Storage::disk('public')->delete($kegiatan->poster);
            }
            $validatedData['poster'] = $this->saveBase64Image($request->input('poster_base64'));
        }

        $kegiatan->update($validatedData);
        return redirect()->route('admin.kegiatans.index')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy(Kegiatan $kegiatan): RedirectResponse
    {
        if ($kegiatan->poster) {
            Storage::disk('public')->delete($kegiatan->poster);
        }
        $kegiatan->delete();
        return redirect()->route('admin.kegiatans.index')->with('success', 'Kegiatan berhasil dihapus.');
    }

    private function saveBase64Image(string $base64Data): string
    {
        @list($type, $imageData) = explode(';', $base64Data);
        @list(, $imageData)      = explode(',', $imageData);
        $imageData = base64_decode($imageData);
        $imageName = 'posters/' . Str::random(40) . '.jpg';
        Storage::disk('public')->put($imageName, $imageData);
        return $imageName;
    }
}
