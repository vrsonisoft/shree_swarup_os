<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Restaurant;
use App\Models\Branch;
use App\Models\User;
use App\Models\Package;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

try {
    $package = Package::first();

    $restaurant = new Restaurant();
    $restaurant->name = 'ShreeSwarup Restaurant';
    $restaurant->hash = md5(microtime());
    $restaurant->address = 'Jodhpur, Rajasthan';
    $restaurant->email = 'restaurant@example.com';
    $restaurant->phone_number = '9876543210';
    $restaurant->timezone = 'Asia/Kolkata';
    $restaurant->theme_hex = '#00b692';
    $restaurant->package_id = $package ? $package->id : 1;
    $restaurant->package_type = 'monthly';
    $restaurant->license_type = 'paid';
    $restaurant->status = 'active';
    $restaurant->save();

    $branch = new Branch();
    $branch->restaurant_id = $restaurant->id;
    $branch->name = 'Main Branch';
    $branch->address = 'Main Street, Jodhpur';
    $branch->save();

    $adminRole = Role::where('name', 'Admin')->where('restaurant_id', $restaurant->id)->first();
    if (!$adminRole) {
        $adminRole = new Role();
        $adminRole->name = 'Admin';
        $adminRole->display_name = 'Admin';
        $adminRole->guard_name = 'web';
        $adminRole->restaurant_id = $restaurant->id;
        $adminRole->save();
    }

    $user = new User();
    $user->name = 'Restaurant Admin';
    $user->email = 'restaurant@example.com';
    $user->password = Hash::make('123456');
    $user->restaurant_id = $restaurant->id;
    $user->branch_id = $branch->id;
    $user->save();

    $user->assignRole($adminRole);

    echo "SUCCESS: Restaurant account created!\n";
    echo "Login Email: restaurant@example.com\n";
    echo "Password: 123456\n";
} catch (\Throwable $e) {
    echo "ERR: " . $e->getMessage() . "\n" . $e->getFile() . ":" . $e->getLine();
}
