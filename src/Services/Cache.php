<?php

namespace App\Services;

class Cache
{
    private $cacheDir = __DIR__ . '/../../cache';
    private $cacheDuration = 3600;

    public function __construct()
    {
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }

    public function get(string $key, $default=null)
    {
        $cacheFile = $this->getCacheFilePath($key);

        // Check if cached file exists and is still valid
        if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $this->cacheDuration) {
            return file_get_contents($cacheFile);
        }

        // Return null if cache does not exist or has expired
        return $default;
    }

    public function put(string $key, $data)
    {
        $cacheFile = $this->getCacheFilePath($key);
        file_put_contents($cacheFile, $data);
    }

    // Generate a unique cache file name based on the key
    private function getCacheFilePath($key)
    {
        $fileName = md5($key) . '.cache';
        return $this->cacheDir . '/' . $fileName;
    }
}