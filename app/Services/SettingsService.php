<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    /**
     * Retrieve a setting by its key, cached forever until updated.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        $settings = Cache::rememberForever('site_settings', function () {
            return Setting::pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }

    /**
     * Clear the settings cache. Should be called by a model observer 
     * or Filament resource whenever a setting is saved/updated.
     *
     * @return void
     */
    public function clearCache(): void
    {
        Cache::forget('site_settings');
    }
}
