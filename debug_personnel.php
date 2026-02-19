<?php
use App\Models\Intervention;
use App\Models\User;
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$interventions = Intervention::all(['id', 'reference', 'statut', 'personnel_id']);
$users = User::where('role', 'personnel')->get(['id', 'name', 'email']);

file_put_contents('debug_output.json', json_encode([
    'interventions' => $interventions,
    'personnel' => $users
], JSON_PRETTY_PRINT));
