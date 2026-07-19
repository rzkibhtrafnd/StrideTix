<?php

namespace App\Http\Controllers;

use App\Services\IndonesianRegionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegionalController extends Controller
{
    protected IndonesianRegionService $regionService;

    public function __construct(IndonesianRegionService $regionService)
    {
        $this->regionService = $regionService;
    }

    public function getProvinces(): JsonResponse
    {
        try {
            $formattedProvinces = $this->regionService->fetchProvinces();
            
            return response()->json(['value' => $formattedProvinces]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal memproses data wilayah.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getRegencies(Request $request): JsonResponse
    {
        try {
            $provinceId = $request->query('id_provinsi');

            if (!$provinceId) {
                return response()->json(['value' => []]);
            }

            $formattedRegencies = $this->regionService->fetchRegencies($provinceId);

            return response()->json(['value' => $formattedRegencies]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal memproses data kabupaten/kota.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}