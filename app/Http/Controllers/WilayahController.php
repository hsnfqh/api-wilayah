<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WilayahController extends Controller
{
    private string $baseUrl = 'https://ihsaninh.github.io/wilayah-indonesia/';

    private function fetchJson(string $path): array
    {
        $response = Http::timeout(10)->get($this->baseUrl . ltrim($path, '/'));

        if (! $response->successful()) {
            return [];
        }

        $payload = $response->json();

        return is_array($payload) ? $payload : [];
    }

    private function getProvinces(): array
    {
        return $this->fetchJson('provinces.json');
    }

    private function getRegencies(string $provinceId): array
    {
        return $this->fetchJson("{$provinceId}/regencies.json");
    }

    private function getDistricts(string $provinceId, string $regencyId): array
    {
        return $this->fetchJson("{$provinceId}/{$regencyId}/district.json");
    }

    private function getSubdistricts(string $provinceId, string $regencyId, string $districtId): array
    {
        return $this->fetchJson("{$provinceId}/{$regencyId}/{$districtId}/subdistrict.json");
    }

    private function cleanId(?string $value): ?string
    {
        if (! is_string($value) || $value === '') {
            return null;
        }

        return preg_match('/^\d+$/', $value) ? $value : null;
    }

    public function provinces()
    {
        $provinces = $this->getProvinces();

        return view('wilayah.provinces', compact('provinces'));
    }

    public function regencies(Request $request, ?string $provinceId = null)
    {
        $provinceId = $this->cleanId($provinceId ?? $request->query('provinceId'));
        $provinces = $this->getProvinces();
        $regencies = $provinceId ? $this->getRegencies($provinceId) : [];

        return view('wilayah.regencies', compact('provinces', 'regencies', 'provinceId'));
    }

    public function districts(Request $request, ?string $provinceId = null, ?string $regencyId = null)
    {
        $provinceId = $this->cleanId($provinceId ?? $request->query('provinceId'));
        $regencyId = $this->cleanId($regencyId ?? $request->query('regencyId'));

        $provinces = $this->getProvinces();
        $regencies = $provinceId ? $this->getRegencies($provinceId) : [];
        $districts = $provinceId && $regencyId ? $this->getDistricts($provinceId, $regencyId) : [];

        return view('wilayah.districts', compact('provinces', 'regencies', 'districts', 'provinceId', 'regencyId'));
    }

    public function subdistricts(Request $request, ?string $provinceId = null, ?string $regencyId = null, ?string $districtId = null)
    {
        $provinceId = $this->cleanId($provinceId ?? $request->query('provinceId'));
        $regencyId = $this->cleanId($regencyId ?? $request->query('regencyId'));
        $districtId = $this->cleanId($districtId ?? $request->query('districtId'));

        $provinces = $this->getProvinces();
        $regencies = $provinceId ? $this->getRegencies($provinceId) : [];
        $districts = $provinceId && $regencyId ? $this->getDistricts($provinceId, $regencyId) : [];
        $subdistricts = $provinceId && $regencyId && $districtId
            ? $this->getSubdistricts($provinceId, $regencyId, $districtId)
            : [];

        return view('wilayah.subdistricts', compact('provinces', 'regencies', 'districts', 'subdistricts', 'provinceId', 'regencyId', 'districtId'));
    }
}
