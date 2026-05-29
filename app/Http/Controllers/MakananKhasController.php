<?php

namespace App\Http\Controllers;

use App\Models\MakananKhas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class MakananKhasController extends Controller
{
    private string $baseUrl = 'https://ihsaninh.github.io/wilayah-indonesia/';

    private function getProvinces(): array
    {
        $response = Http::timeout(10)->get($this->baseUrl . 'provinces.json');

        if (! $response->successful()) {
            return [];
        }

        $payload = $response->json();

        return is_array($payload) ? $payload : [];
    }

    private function findProvinceById(?string $provinceId): ?array
    {
        if (! is_string($provinceId) || ! preg_match('/^\d+$/', $provinceId)) {
            return null;
        }

        return collect($this->getProvinces())->firstWhere('id', $provinceId);
    }

    public function index(Request $request)
    {
        $provinceId = $request->query('provinceId');
        $query = MakananKhas::query()->latest(); // DEFAULT ORDER BY created_at DESC

        if ($provinceId) {
            $query->where('province_id', $provinceId);
        }

        $makananList = $query->get();
        $provinces = $this->getProvinces();

        return view('makanan-khas.index', compact('makananList', 'provinces', 'provinceId'));
    }

    public function create(Request $request)
    {
        $provinces = $this->getProvinces();
        $selectedProvinceId = $request->query('provinceId');

        return view('makanan-khas.create', compact('provinces', 'selectedProvinceId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'province_id' => ['required', 'string', 'regex:/^\d+$/'],
            'nama_makanan' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $province = $this->findProvinceById($validated['province_id']);
        if (! $province) {
            return back()->withInput()->withErrors(['province_id' => 'Provinsi tidak valid.']);
        }

        $fotoPath = $request->file('foto')?->store('makanan-khas', 'public');

        MakananKhas::create([
            'province_id' => $validated['province_id'],
            'province_name' => $province['value'],
            'nama_makanan' => $validated['nama_makanan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'foto_path' => $fotoPath,
        ]);

        return redirect()
            ->route('makanan-khas.index', ['provinceId' => $validated['province_id']])
            ->with('success', 'Makanan khas berhasil ditambahkan.');
    }

    public function edit(MakananKhas $makananKhas)
    {
        $provinces = $this->getProvinces();

        return view('makanan-khas.edit', compact('makananKhas', 'provinces'));
    }

    public function update(Request $request, MakananKhas $makananKhas)
    {
        $validated = $request->validate([
            'province_id' => ['required', 'string', 'regex:/^\d+$/'],
            'nama_makanan' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $province = $this->findProvinceById($validated['province_id']);
        if (! $province) {
            return back()->withInput()->withErrors(['province_id' => 'Provinsi tidak valid.']);
        }

        $fotoPath = $makananKhas->foto_path;
        if ($request->hasFile('foto')) {
            if ($fotoPath) {
                Storage::disk('public')->delete($fotoPath);
            }

            $fotoPath = $request->file('foto')->store('makanan-khas', 'public');
        }

        $makananKhas->update([
            'province_id' => $validated['province_id'],
            'province_name' => $province['value'],
            'nama_makanan' => $validated['nama_makanan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'foto_path' => $fotoPath,
        ]);

        return redirect()
            ->route('makanan-khas.index', ['provinceId' => $validated['province_id']])
            ->with('success', 'Data makanan khas berhasil diperbarui.');
    }

    public function destroy(MakananKhas $makananKhas)
    {
        $provinceId = $makananKhas->province_id;

        if ($makananKhas->foto_path) {
            Storage::disk('public')->delete($makananKhas->foto_path);
        }

        $makananKhas->delete();

        return redirect()
            ->route('makanan-khas.index', ['provinceId' => $provinceId])
            ->with('success', 'Data makanan khas berhasil dihapus.');
    }
}
