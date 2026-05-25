<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RegionController extends Controller
{
    private $baseUrl = 'https://wilayah.id/api';

    public function provinces()
    {
        $response = Http::get("{$this->baseUrl}/provinces.json");
        return response()->json($response->json());
    }

    public function regencies($provinceCode)
    {
        $response = Http::get("{$this->baseUrl}/regencies/{$provinceCode}.json");
        return response()->json($response->json());
    }

    public function districts($regencyCode)
    {
        $response = Http::get("{$this->baseUrl}/districts/{$regencyCode}.json");
        return response()->json($response->json());
    }

    public function villages($districtCode)
    {
        $response = Http::get("{$this->baseUrl}/villages/{$districtCode}.json");
        return response()->json($response->json());
    }
}
