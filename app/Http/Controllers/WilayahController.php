<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;  // Untuk panggil API

class WilayahController extends Controller
{
    // BASE URL API
    private $baseUrl = 'https://ihsaninh.github.io/wilayah-indonesia/';
    
    // ========== 1. AMBIL SEMUA PROVINSI ==========
    private function getProvinces()
    {
        $response = Http::get($this->baseUrl . 'provinces.json');
        
        if ($response->successful()) {
            return $response->json();  // [{"id":11,"value":"ACEH"}, ...]
        }
        
        return [];
    }
    
    // ========== 2. AMBIL KOTA BERDASARKAN ID PROVINSI ==========
    private function getRegencies($provinceId)
    {
        $url = $this->baseUrl . $provinceId . '/regencies.json';
        $response = Http::get($url);
        
        if ($response->successful()) {
            return $response->json();
        }
        
        return [];
    }
    
    // ========== 3. AMBIL KECAMATAN BERDASARKAN ID KOTA ==========
    private function getDistricts($provinceId, $regencyId)
    {
        $url = $this->baseUrl . $provinceId . '/' . $regencyId . '/district.json';
        $response = Http::get($url);
        
        if ($response->successful()) {
            return $response->json();
        }
        
        return [];
    }
    
    // ========== 4. AMBIL KELURAHAN BERDASARKAN ID KECAMATAN ==========
    private function getSubdistricts($provinceId, $regencyId, $districtId)
    {
        $url = $this->baseUrl . $provinceId . '/' . $regencyId . '/' . $districtId . '/subdistrict.json';
        $response = Http::get($url);
        
        if ($response->successful()) {
            return $response->json();
        }
        
        return [];
    }
    
    // ========== HALAMAN PROVINSI ==========
    public function provinces()
    {
        $provinces = $this->getProvinces();
        return view('wilayah.provinces', compact('provinces'));
    }
    
    // ========== HALAMAN KOTA (Filter by Provinsi) ==========
    public function regencies($provinceId = null)
    {
        $provinces = $this->getProvinces();
        $regencies = [];
        
        if ($provinceId) {
            $regencies = $this->getRegencies($provinceId);
        }
        
        return view('wilayah.regencies', compact('provinces', 'regencies', 'provinceId'));
    }
    
    // ========== HALAMAN KECAMATAN (Filter by Kota) ==========
    public function districts($provinceId = null, $regencyId = null)
    {
        $provinces = $this->getProvinces();
        $regencies = [];
        $districts = [];
        
        if ($provinceId) {
            $regencies = $this->getRegencies($provinceId);
        }
        
        if ($provinceId && $regencyId) {
            $districts = $this->getDistricts($provinceId, $regencyId);
        }
        
        return view('wilayah.districts', compact('provinces', 'regencies', 'districts', 'provinceId', 'regencyId'));
    }
    
    // ========== HALAMAN KELURAHAN (Filter by Kecamatan) ==========
    public function subdistricts($provinceId = null, $regencyId = null, $districtId = null)
    {
        $provinces = $this->getProvinces();
        $regencies = [];
        $districts = [];
        $subdistricts = [];
        
        if ($provinceId) {
            $regencies = $this->getRegencies($provinceId);
        }
        
        if ($provinceId && $regencyId) {
            $districts = $this->getDistricts($provinceId, $regencyId);
        }
        
        if ($provinceId && $regencyId && $districtId) {
            $subdistricts = $this->getSubdistricts($provinceId, $regencyId, $districtId);
        }
        
        return view('wilayah.subdistricts', compact('provinces', 'regencies', 'districts', 'subdistricts', 'provinceId', 'regencyId', 'districtId'));
    }
}