<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$migration = DB::table('migrations')->where('migration', '2026_05_11_202400_add_parent_id_to_departments_table')->first();
echo "Migration record: " . ($migration ? 'Found' : 'Not Found') . "\n";
