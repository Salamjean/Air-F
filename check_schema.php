<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$columns = Schema::getColumnListing('interventions');
echo "Columns in 'interventions' table:\n";
print_r($columns);

$hasRapportPath = Schema::hasColumn('interventions', 'rapport_path');
echo "\nHas 'rapport_path': " . ($hasRapportPath ? 'YES' : 'NO') . "\n";
