<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class IndonesianRegionService
{
    protected string $baseUrl = 'https://emsifa.github.io/api-wilayah-indonesia/api';

    public function fetchProvinces(): array
    {
        $response = Http::withHeaders(['Accept' => 'application/json'])
            ->get("{$this->baseUrl}/provinces.json");

        if (!$response->successful()) {
            throw new Exception("Gagal mengambil data provinsi dari server eksternal.");
        }

        $provinces = $response->json();
        
        if (!is_array($provinces)) {
            return [];
        }

        return array_map(function ($prov) {
            return [
                'id'   => $prov['id'],
                'name' => ucwords(strtolower($prov['name']))
            ];
        }, $provinces);
    }

    public function fetchRegencies(string $provinceId): array
    {
        $cleanId = trim($provinceId);
        
        $response = Http::withHeaders(['Accept' => 'application/json'])
            ->get("{$this->baseUrl}/regencies/{$cleanId}.json");

        if (!$response->successful()) {
            throw new Exception("Gagal mengambil data kabupaten/kota dari server eksternal.");
        }

        $regencies = $response->json();

        if (!is_array($regencies)) {
            return [];
        }

        return array_map(function ($reg) {
            return [
                'id'   => $reg['id'],
                'name' => ucwords(strtolower($reg['name']))
            ];
        }, $regencies);
    }
}