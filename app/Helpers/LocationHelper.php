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
    
    // New helper methods to convert codes to names
    
    /**
     * Get region name by region code
     * 
     * @param string $regionCode
     * @return string
     */
    public static function getRegionName($regionCode)
    {
        if (empty($regionCode)) {
            return '';
        }
        
        $regions = self::getRegions();
        foreach ($regions as $region) {
            if ($region['region_code'] == $regionCode) {
                return $region['region_name'];
            }
        }
        
        return $regionCode; // Return the code if not found
    }
    
    /**
     * Get province name by province code
     * 
     * @param string $provinceCode
     * @return string
     */
    public static function getProvinceName($provinceCode)
    {
        if (empty($provinceCode)) {
            return '';
        }
        
        $provinces = self::getProvinces();
        foreach ($provinces as $province) {
            if ($province['province_code'] == $provinceCode) {
                return $province['province_name'];
            }
        }
        
        return $provinceCode; // Return the code if not found
    }
    
    /**
     * Get city/municipality name by city code
     * 
     * @param string $cityCode
     * @return string
     */
    public static function getCityName($cityCode)
    {
        if (empty($cityCode)) {
            return '';
        }
        
        $cities = self::getCities();
        foreach ($cities as $city) {
            if ($city['city_code'] == $cityCode) {
                return $city['city_name'];
            }
        }
        
        return $cityCode; // Return the code if not found
    }
    
    /**
     * Get barangay name by barangay code
     * 
     * @param string $brgyCode
     * @return string
     */
    public static function getBarangayName($brgyCode)
    {
        if (empty($brgyCode)) {
            return '';
        }
        
        $barangays = self::getBarangays();
        foreach ($barangays as $barangay) {
            if ($barangay['brgy_code'] == $brgyCode) {
                return $barangay['brgy_name'];
            }
        }
        
        return $brgyCode; // Return the code if not found
    }
}