<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LocationHelper
{
    private static function ensureDirectoryExists()
    {
        $path = storage_path('app/locations');
        
        if (!file_exists($path)) {
            Log::warning('Locations directory missing, attempting creation', ['path' => $path]);
            
            if (!mkdir($path, 0755, true) && !is_dir($path)) {
                $error = error_get_last();
                Log::error('Directory creation failed', [
                    'path' => $path,
                    'error' => $error['message'] ?? 'Unknown error'
                ]);
                throw new \RuntimeException("Failed to create directory: {$path}. Error: {$error['message']}");
            }
        }
        
        if (!is_readable($path)) {
            Log::error('Directory not readable', [
                'path' => $path,
                'permissions' => substr(sprintf('%o', fileperms($path)), -4)
            ]);
            throw new \RuntimeException("Directory not readable: {$path}");
        }
        
        return $path;
    }

    private static function loadJson($filename)
    {
        try {
            $directory = self::ensureDirectoryExists();
            $path = "{$directory}/{$filename}";
            
            if (!file_exists($path)) {
                $debugInfo = [
                    'searched_path' => $path,
                    'directory_contents' => scandir($directory),
                    'storage_root' => storage_path(),
                    'time' => now()->toDateTimeString()
                ];
                
                Log::error("JSON file not found: {$filename}", $debugInfo);
                throw new \Exception("Location data file not found: {$filename}");
            }
            
            $json = file_get_contents($path);
            if ($json === false) {
                throw new \Exception("Failed to read file: {$filename}");
            }
            
            $data = json_decode($json, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Invalid JSON in {$filename}: " . json_last_error_msg());
            }
            
            return $data;
            
        } catch (\Exception $e) {
            Log::critical("LocationHelper error: " . $e->getMessage(), [
                'file' => $filename,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e; // Re-throw after logging
        }
    }

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
    
    public static function getRegionName($regionCode)
    {
        if (empty($regionCode)) return '';
        
        try {
            $regions = self::getRegions();
            foreach ($regions as $region) {
                if ($region['region_code'] == $regionCode) {
                    return $region['region_name'];
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to get region name", [
                'code' => $regionCode,
                'error' => $e->getMessage()
            ]);
        }
        
        return $regionCode;
    }
    
    public static function getProvinceName($provinceCode)
    {
        if (empty($provinceCode)) return '';
        
        try {
            $provinces = self::getProvinces();
            foreach ($provinces as $province) {
                if ($province['province_code'] == $provinceCode) {
                    return $province['province_name'];
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to get province name", [
                'code' => $provinceCode,
                'error' => $e->getMessage()
            ]);
        }
        
        return $provinceCode;
    }
    
    public static function getCityName($cityCode)
    {
        if (empty($cityCode)) return '';
        
        try {
            $cities = self::getCities();
            foreach ($cities as $city) {
                if ($city['city_code'] == $cityCode) {
                    return $city['city_name'];
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to get city name", [
                'code' => $cityCode,
                'error' => $e->getMessage()
            ]);
        }
        
        return $cityCode;
    }
    
    public static function getBarangayName($brgyCode)
    {
        if (empty($brgyCode)) return '';
        
        try {
            $barangays = self::getBarangays();
            foreach ($barangays as $barangay) {
                if ($barangay['brgy_code'] == $brgyCode) {
                    return $barangay['brgy_name'];
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to get barangay name", [
                'code' => $brgyCode,
                'error' => $e->getMessage()
            ]);
        }
        
        return $brgyCode;
    }

    /**
     * Verify all required location files exist
     */
    public static function verifyFiles()
    {
        $requiredFiles = ['region.json', 'province.json', 'city.json', 'barangay.json'];
        $missingFiles = [];
        
        foreach ($requiredFiles as $file) {
            if (!file_exists(storage_path("app/locations/{$file}"))) {
                $missingFiles[] = $file;
            }
        }
        
        if (!empty($missingFiles)) {
            Log::error('Missing location data files', ['files' => $missingFiles]);
            return false;
        }
        
        return true;
    }

    public static function getLocationFiles()
{
    try {
        $path = self::ensureDirectoryExists();
        
        $files = scandir($path);
        if ($files === false) {
            throw new \RuntimeException("Failed to scan directory: {$path}");
        }
        
        return array_values(array_diff($files, ['.', '..'])); // Remove . and ..
        
    } catch (\Exception $e) {
        Log::error('LocationHelper file scan failed: ' . $e->getMessage());
        return []; // Return empty array on failure
    }
}
}