<?php

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== ADMIN USERS ===\n";
$admins = Admin::all();
foreach ($admins as $admin) {
    echo "ID: {$admin->id}, Username: {$admin->username}, Email: {$admin->email}, Status: {$admin->status}\n";
    echo "  Password hash: " . substr($admin->password, 0, 60) . "...\n";
    echo "  Hash::check('12345678'): " . (Hash::check('12345678', $admin->password) ? 'YES' : 'NO') . "\n\n";
}

echo "\n=== REGULAR USERS ===\n";
$users = User::all();
foreach ($users as $user) {
    echo "ID: {$user->id}, Username: {$user->username}, Email: {$user->email}, Status: {$user->status}\n";
    echo "  Password hash: " . substr($user->password, 0, 60) . "...\n";
    echo "  Hash::check('12345678'): " . (Hash::check('12345678', $user->password) ? 'YES' : 'NO') . "\n\n";
}

// Check if there are status requirements
echo "\n=== STATUS CHECK ===\n";
echo "Admin status field values: ";
print_r(Admin::pluck('status', 'username')->toArray());
echo "\nUser status field values: ";
print_r(User::pluck('status', 'username')->toArray());
