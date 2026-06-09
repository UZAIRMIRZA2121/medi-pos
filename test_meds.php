<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$meds = \App\Models\Medicine::all();
foreach($meds as $m) {
    echo "ID: {$m->id} | Name: {$m->name} | Stock: {$m->stock_quantity} | Price: {$m->sale_price}\n";
}
