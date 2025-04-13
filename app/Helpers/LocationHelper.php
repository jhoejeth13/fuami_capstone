<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

class LocationHelper
{
    private const LOCATIONS_DIR = 'app/locations';
    private const REQUIRED_FILES = [
        'region.json',
        'province.json',
        'city.json',
        'barangay.json'
    ];

    /**
     * Ensure the locations directory exists and is accessible
     */
    private static function ensureDirectoryExists(): string
    {
        $path = storage_path(self::LOCATIONS_DIR);
        
        try {
            if (!file_exists($path)) {
                if (!Storage::makeDirectory(self::LOCATIONS_DIR)) {
                    throw new \RuntimeException("Directory creation failed: {$path}");
                }
            }

            if (!is_readable($path)) {
                throw new \RuntimeException("Directory not readable: {$path}");
            }

            return $path;
        } catch (\Exception $e) {
            Log::error('Location directory error: ' . $e->getMessage(), [
                'path' => $path,
                'permissions' => file_exists($path) ? substr(sprintf('%o', fileperms($path)), -4) : 'none'
            ]);
            throw $e;
        }
    }

    /**
     * Load JSON file with multiple fallback options
     */
    private static function loadJson(string $filename): array
    {
        try {
            $path = storage_path(self::LOCATIONS_DIR.'/'.$filename);

            // First try using Laravel's Storage facade
            if (Storage::exists(self::LOCATIONS_DIR.'/'.$filename)) {
                $json = Storage::get(self::LOCATIONS_DIR.'/'.$filename);
                $data = json_decode($json, true);
                
                if (json_last_error() === JSON_ERROR_NONE) {
                    return $data;
                }
            }

            // Fallback to direct file access
            if (file_exists($path)) {
                $json = file_get_contents($path);
                $data = json_decode($json, true);
                
                if (json_last_error() === JSON_ERROR_NONE) {
                    return $data;
                }
                throw new \RuntimeException("Invalid JSON in {$filename}: " . json_last_error_msg());
            }

            // Final fallback to empty array
            Log::warning("Location file not found, returning empty array", ['file' => $filename]);
            return [];

        } catch (\Exception $e) {
            Log::error("LocationHelper error loading {$filename}: " . $e->getMessage());
            return []; // Return empty array instead of throwing exception
        }
    }

    /**
     * Cache frequently accessed location data
     */
    private static function cachedLoad(string $filename): array
    {
        static $cache = [];
        
        if (!isset($cache[$filename])) {
            $cache[$filename] = self::loadJson($filename);
        }
        
        return $cache[$filename];
    }

    /**
     * Find item by code in location data
     */
    private static function findItem(string $filename, ?string $code, string $codeField, string $nameField): string
    {
        if (empty($code)) {
            return '';
        }

        $items = self::cachedLoad($filename);
        $found = Arr::first($items, fn($item) => ($item[$codeField] ?? null) == $code);
        
        return $found[$nameField] ?? $code;
    }

    // Public API Methods

    public static function getRegions(): array
    {
        return array_map(function($region) {
            return [
                'region_code' => $region['region_code'] ?? null,
                'region_name' => $region['region_name'] ?? null,
                'psgc_code' => $region['psgc_code'] ?? null
            ];
        }, self::cachedLoad('region.json'));
    }

    public static function getProvinces(): array
    {
        return self::cachedLoad('province.json');
    }

    public static function getCities(): array
    {
        return self::cachedLoad('city.json');
    }

    public static function getBarangays(?string $cityCode = null): array
    {
        $barangays = self::cachedLoad('barangay.json');
        
        if ($cityCode) {
            return array_filter($barangays, fn($barangay) => ($barangay['city_code'] ?? null) == $cityCode);
        }
        
        return $barangays;
    }

    public static function getRegionName(?string $regionCode): string
    {
        return self::findItem('region.json', $regionCode, 'region_code', 'region_name');
    }

    public static function getProvinceName(?string $provinceCode): string
    {
        return self::findItem('province.json', $provinceCode, 'province_code', 'province_name');
    }

    public static function getCityName(?string $cityCode): string
    {
        return self::findItem('city.json', $cityCode, 'city_code', 'city_name');
    }

    public static function getBarangayName(?string $brgyCode): string
    {
        return self::findItem('barangay.json', $brgyCode, 'brgy_code', 'brgy_name');
    }

    /**
     * Verify all required location files exist
     */
    public static function verifyFiles(): bool
    {
        foreach (self::REQUIRED_FILES as $file) {
            if (!Storage::exists(self::LOCATIONS_DIR.'/'.$file) && !file_exists(storage_path(self::LOCATIONS_DIR.'/'.$file))) {
                Log::error('Missing location file', ['file' => $file]);
                return false;
            }
        }
        return true;
    }

    /**
     * Get list of available location files
     */
    public static function getLocationFiles(): array
    {
        try {
            $path = self::ensureDirectoryExists();
            $files = array_diff(scandir($path), ['.', '..']);
            return array_values($files);
        } catch (\Exception $e) {
            Log::error('File listing failed: '.$e->getMessage());
            return [];
        }
    }

    /**
     * Preload all location data into cache
     */
    public static function warmupCache(): void
    {
        foreach (self::REQUIRED_FILES as $file) {
            self::cachedLoad($file);
        }
    }
}