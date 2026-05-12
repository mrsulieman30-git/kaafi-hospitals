<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Setting;
use Illuminate\Support\Facades\DB;

$siteSetting = DB::table('site_settings')->first();

if ($siteSetting) {
    $data = [
        'logo_path' => $siteSetting->logo_path,
        'logo_height' => $siteSetting->logo_height,
        'logo_position' => $siteSetting->logo_position,
        'hero_bg_path' => $siteSetting->hero_bg_path,
        'hero_bg_opacity' => $siteSetting->hero_bg_opacity,
        'chatbot_avatar_path' => $siteSetting->chatbot_avatar_path,
        'location_coordinates' => $siteSetting->location_coordinates,
    ];

    foreach ($data as $key => $value) {
        // Clean up double escaping if it exists for coordinates
        if ($key === 'location_coordinates' && is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_string($decoded)) {
                $value = $decoded; // It was double encoded
            }
        }

        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => 'text', 'group' => 'brand']
        );
    }
    echo "Data migrated from site_settings to settings table successfully!\n";
} else {
    echo "No data found in site_settings table.\n";
}
