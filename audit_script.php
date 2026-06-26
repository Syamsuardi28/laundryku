<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$admin = User::where('role', 'admin')->first();
if (!$admin) {
    $admin = User::create([
        'name' => 'Admin Test',
        'email' => 'admintest@example.com',
        'password' => bcrypt('password'),
        'role' => 'admin'
    ]);
}
auth()->login($admin);

$customer = Customer::first() ?? Customer::create(['nama' => 'Test Customer', 'telepon' => '08123456789']);
$service = Service::first() ?? Service::create(['nama_layanan' => 'Test Service', 'harga_per_kg' => 10000]);
$transaction = Transaction::first() ?? Transaction::create([
    'customer_id' => $customer->id,
    'user_id' => $admin->id,
    'service_id' => $service->id,
    'nomor_transaksi' => 'TRX-' . time(),
    'invoice_number' => 'INV-' . time(),
    'berat' => 2,
    'total_harga' => 20000,
    'status' => 'Diproses',
    'tanggal_masuk' => now(),
    'tanggal_estimasi' => now()->addDays(2),
]);

$routesToTest = [
    'dashboard' => [],
    'settings.index' => [],
    
    'customers.index' => [],
    'customers.create' => [],
    'customers.edit' => ['customer' => $customer->id],
    
    'services.index' => [],
    'services.create' => [],
    'services.edit' => ['service' => $service->id],
    
    'transactions.index' => [],
    'transactions.create' => [],
    'transactions.edit' => ['transaction' => $transaction->id],
    'transactions.show' => ['transaction' => $transaction->id],
    
    'reports.index' => [],
    'search.index' => [],
    
    'users.index' => [],
    'users.create' => [],
    'users.edit' => ['user' => $admin->id],
];

echo "Starting Feature Audit...\n";
echo "============================\n";

$errors = [];

foreach ($routesToTest as $routeName => $params) {
    try {
        $url = route($routeName, $params);
        $request = Request::create($url, 'GET');
        $response = app()->handle($request);
        
        if ($response->status() >= 400) {
            $errors[] = "$routeName ($url) returned status " . $response->status();
        } else {
            echo "[OK] $routeName\n";
        }
    } catch (\Exception $e) {
        $errors[] = "$routeName failed with Exception: " . get_class($e) . " - " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
    }
}

echo "============================\n";
if (empty($errors)) {
    echo "All tested routes rendered successfully!\n";
} else {
    echo "ERRORS FOUND:\n";
    foreach ($errors as $error) {
        echo "- $error\n";
    }
}
