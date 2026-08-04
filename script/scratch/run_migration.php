<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
Illuminate\Support\Facades\Artisan::call('migrate');
echo "Migrated successfully!\n" . Illuminate\Support\Facades\Artisan::output();
