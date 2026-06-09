<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$req = Illuminate\Http\Request::create('/pos/checkout', 'POST', [
    'customer_id' => null,
    'discount_percent' => 0,
    'tax_percent' => 0,
    'paid_amount' => 100,
    'payment_method' => 'cash',
    'items' => [
        ['medicine_id' => 1, 'quantity' => 1, 'unit_price' => 10]
    ]
]);

$c = new \App\Http\Controllers\PosController;
try {
    $res = $c->checkout($req);
    echo $res->getContent();
} catch(\Exception $e) {
    echo "EXCEPTION: " . $e->getMessage();
}
