<?php

namespace App\Helpers;

class LocationHelper
{
    private static function loadJson($filename)
    {
        // Change this line to include the locations subdirectory
        $path = storage_path("app/locations/{$filename}");
        
        if (!file_exists($path)) {
            // Add debug information
            $debug = [
                'searched_path' => $path,
                'storage_path' => storage_path(),
                'directory_contents' => scandir(storage_path('app/locations'))
            ];
            throw new \Exception("File not found: {$filename}. Debug: " . json_encode($debug));
        }
        
        $data = json_decode(file_get_contents($path), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Invalid JSON in {$filename}: " . json_last_error_msg());
        }
        
        return $data;
    }

    // Keep the rest of your methods the same
    public static function getRegions()
    {
        $regions = self::loadJson('region.json');
        return array_map(function($region) {
            return [
                'region_code' => $region['region_code'],
                'region_name' => $region['region_name'],
                'psgc_code' => $region['psgc_code'] ?? null
            ];
        }, $regions);
    }

    public static function getProvinces()
    {
        return self::loadJson('province.json');
    }

    public static function getCities()
    {
        return self::loadJson('city.json');
    }

    public static function getBarangays()
    {
        return self::loadJson('barangay.json');
    }
}