<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $controller = app()->make(\App\Http\Controllers\MemberController::class);
    $response = $controller->index();
    echo "SUCCESS\n";
    echo substr($response->render(), 0, 200);
} catch (\Throwable $e) {
    echo "ERROR LOGGED:\n";
    echo $e->getMessage() . "\n";
    echo "AT: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
