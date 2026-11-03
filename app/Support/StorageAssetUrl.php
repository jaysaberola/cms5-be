<?php

namespace App\Support;

class StorageAssetUrl
{
    public static function publicDisk(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        $normalized = trim(str_replace('\\', '/', (string) $path));

        if (preg_match('#^https?://#i', $normalized)) {
            return $normalized;
        }

        $normalized = ltrim($normalized, '/');

        return '/storage/' . $normalized;
    }
}
