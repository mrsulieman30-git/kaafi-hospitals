<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;

$columns = Schema::getColumnListing('departments');
echo "Columns in departments table: " . implode(', ', $columns) . "\n";

$exists = Schema::hasColumn('departments', 'parent_id');
echo "Does parent_id exist? " . ($exists ? 'Yes' : 'No') . "\n";
