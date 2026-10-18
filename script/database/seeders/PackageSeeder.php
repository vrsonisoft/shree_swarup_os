<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Package;
use App\Models\GlobalCurrency;
use Illuminate\Database\Seeder;
use App\Enums\PackageType;
use App\Scopes\ModuleScope;

class PackageSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch INR currency ID (fallback to first available currency)
        $currency = GlobalCurrency::where('currency_code', 'INR')->first() ?? GlobalCurrency::first();
        $currencyID = $currency ? $currency->id : 1;

        $modules = Module::withoutGlobalScope(ModuleScope::class)
            ->where('is_superadmin', 0)
            ->get();
        $moduleIds = $modules->pluck('id')->toArray();

        // 1. Create / Update the Default package
        $defaultPackage = Package::updateOrCreate(
            ['id' => 1],
            [
                'package_name'     => 'Default',
                'description'      => 'System default package and cannot be deleted.',
                'currency_id'      => $currencyID,
                'monthly_status'   => 0,
                'annual_status'    => 0,
                'annual_price'     => null,
                'monthly_price'    => null,
                'price'            => 0,
                'is_free'          => 1,
                'billing_cycle'    => 12,
                'sort_order'       => 1,
                'is_private'       => 1,
                'is_recommended'   => 0,
                'package_type'     => PackageType::DEFAULT,
            ]
        );
        $defaultPackage->modules()->sync($moduleIds);

        // 2. Create / Update the Starter package (₹499 / mo, ₹4,999 / yr)
        $starterPackage = Package::updateOrCreate(
            ['id' => 2],
            [
                'package_name'        => 'Starter',
                'description'         => 'Ideal for small cafes, bakeries, food trucks, and quick-service counters.',
                'currency_id'         => $currencyID,
                'monthly_status'      => 1,
                'annual_status'       => 1,
                'annual_price'        => 4999.00,
                'monthly_price'       => 499.00,
                'price'               => 499.00,
                'is_free'             => 0,
                'billing_cycle'       => 12,
                'sort_order'          => 1,
                'is_private'          => 0,
                'is_recommended'      => 0,
                'package_type'        => PackageType::STANDARD,
                'branch_limit'        => 1,
                'multipos_limit'      => 1,
                'menu_items_limit'    => -1,
                'order_limit'         => -1,
                'staff_limit'         => 2,
                'additional_features' => json_encode([
                    '1 Restaurant Branch',
                    '1 POS Billing Counter',
                    'QR Code Digital Menu',
                    'Takeaway & Delivery Orders',
                    'Thermal Slip Printing',
                    'Daily Sales & Revenue Reports',
                    '2 Staff User Accounts',
                    'Standard Email/Chat Support',
                ]),
            ]
        );
        $starterPackage->modules()->sync($moduleIds);

        // 3. Create / Update the Pro package (₹999 / mo, ₹8,999 / yr - ⭐ Most Popular)
        $proPackage = Package::updateOrCreate(
            ['id' => 3],
            [
                'package_name'        => 'Pro',
                'description'         => 'Complete Restaurant OS for dine-in restaurants, cafes, bars, and lounges.',
                'currency_id'         => $currencyID,
                'monthly_status'      => 1,
                'annual_status'       => 1,
                'annual_price'        => 8999.00,
                'monthly_price'       => 999.00,
                'price'               => 999.00,
                'is_free'             => 0,
                'billing_cycle'       => 10,
                'sort_order'          => 2,
                'is_private'          => 0,
                'is_recommended'      => 1,
                'package_type'        => PackageType::STANDARD,
                'branch_limit'        => 1,
                'multipos_limit'      => 3,
                'menu_items_limit'    => -1,
                'order_limit'         => -1,
                'staff_limit'         => 10,
                'additional_features' => json_encode([
                    'Everything in Starter, plus:',
                    'Live Table & Floor Layout Management',
                    'Contactless QR Table Ordering',
                    'Kitchen Order Tickets (KOT) & KDS',
                    'ChowChak Thermal Printer App',
                    'Up to 3 POS Billing Counters',
                    'Waiter Call & Staff Assignment',
                    'Expense & Cash Register Tracking',
                    'Customer CRM & Order History',
                    '10 Staff Accounts (Waiter, Chef, Cashier)',
                    'Priority Phone & WhatsApp Support',
                ]),
            ]
        );
        $proPackage->modules()->sync($moduleIds);

        // 4. Create / Update the Enterprise package (₹1,999 / mo, ₹17,999 / yr)
        $enterprisePackage = Package::updateOrCreate(
            ['id' => 4],
            [
                'package_name'        => 'Enterprise',
                'description'         => 'Built for multi-outlet restaurant chains, franchises, and large food establishments.',
                'currency_id'         => $currencyID,
                'monthly_status'      => 1,
                'annual_status'       => 1,
                'annual_price'        => 17999.00,
                'monthly_price'       => 1999.00,
                'price'               => 1999.00,
                'is_free'             => 0,
                'billing_cycle'       => 12,
                'sort_order'          => 3,
                'is_private'          => 0,
                'is_recommended'      => 0,
                'package_type'        => PackageType::STANDARD,
                'branch_limit'        => 3,
                'multipos_limit'      => -1,
                'menu_items_limit'    => -1,
                'order_limit'         => -1,
                'staff_limit'         => -1,
                'additional_features' => json_encode([
                    'Everything in Pro, plus:',
                    'Multi-Branch Centralized Management (3 Outlets)',
                    'Unlimited POS Terminals & Counters',
                    'Multi-Kitchen KOT Routing',
                    'Advanced Table Reservations & Booking',
                    'Unlimited Staff & Custom Roles',
                    'Consolidated Multi-Outlet Analytics',
                    'Custom Brand Logo on QR & Receipts',
                    'Dedicated 24/7 Account Manager & SLA',
                ]),
            ]
        );
        $enterprisePackage->modules()->sync($moduleIds);

        // 5. Create / Update the 14-Day Trial package
        $trialPackage = Package::updateOrCreate(
            ['id' => 5],
            [
                'package_name'                  => 'Trial Package',
                'description'                   => '14 Days full-featured free trial to experience the power of ChowChak.',
                'currency_id'                   => $currencyID,
                'monthly_status'                => 0,
                'annual_status'                 => 0,
                'annual_price'                  => null,
                'monthly_price'                 => null,
                'price'                         => 0,
                'is_free'                       => 1,
                'billing_cycle'                 => 0,
                'sort_order'                    => null,
                'is_private'                    => 0,
                'is_recommended'                => 0,
                'package_type'                  => PackageType::TRIAL,
                'trial_days'                    => 14,
                'trial_status'                  => 1,
                'trial_notification_before_days'=> 3,
                'trial_message'                 => '14 Days Free Trial',
                'branch_limit'                  => 1,
                'multipos_limit'                => 3,
                'staff_limit'                   => 10,
                'menu_items_limit'              => -1,
                'order_limit'                   => -1,
                'additional_features'           => json_encode([
                    '14-Day Full Access to Pro Features',
                    'QR Code Menu & Table Ordering',
                    'Kitchen Order Tickets (KOT)',
                    'ChowChak Thermal Printer App',
                    'Up to 3 POS Billing Counters',
                    '10 Staff Accounts',
                ]),
            ]
        );
        $trialPackage->modules()->sync($moduleIds);
    }

}
