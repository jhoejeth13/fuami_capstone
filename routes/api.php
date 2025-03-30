<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Helpers\LocationHelper;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/provinces', function (Request $request) {
    try {
        $regionCode = $request->query('region');
        
        $provinces = collect(LocationHelper::getProvinces())
            ->where('region_code', $regionCode)
            ->map(function($item) {
                return [
                    'code' => $item['province_code'],
                    'name' => $item['province_name']
                ];
            })
            ->values()
            ->toArray();

        return response()->json($provinces);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTrace()
        ], 500);
    }
});

Route::get('/cities', function (Request $request) {
    try {
        $provinceCode = $request->query('province');
        
        $cities = collect(LocationHelper::getCities())
            ->where('province_code', $provinceCode)
            ->map(function($item) {
                return [
                    'code' => $item['city_code'],
                    'name' => $item['city_name']
                ];
            })
            ->values()
            ->toArray();

        return response()->json($cities);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTrace()
        ], 500);
    }
});

Route::get('/barangays', function (Request $request) {
    try {
        $cityCode = $request->query('city');
        
        $barangays = collect(LocationHelper::getBarangays())
            ->where('city_code', $cityCode)
            ->map(function($item) {
                return [
                    'code' => $item['brgy_code'],
                    'name' => $item['brgy_name']
                ];
            })
            ->values()
            ->toArray();

        return response()->json($barangays);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTrace()
        ], 500);
    }
});