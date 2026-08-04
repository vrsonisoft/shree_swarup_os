<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TutorialCategory;
use App\Models\TutorialSubCategory;
use Illuminate\Support\Str;

class TutorialCategorySeeder extends Seeder
{
    public function run()
    {
        $categoriesData = [
            [
                'name' => 'Dashboard & Setup',
                'slug' => 'dashboard-setup',
                'description' => 'Restaurant profile, table QR, and staff setup tutorials.',
                'sub_categories' => [
                    ['name' => 'REST.SETTINGS', 'slug' => 'rest-settings', 'description' => 'Restaurant Settings & Profile Configuration'],
                    ['name' => 'TABLES & QR', 'slug' => 'tables-qr', 'description' => 'Table Management & QR Code Generation'],
                    ['name' => 'STAFF & WAITER', 'slug' => 'staff-waiter', 'description' => 'Staff Roles, Waiters & Permissions'],
                ]
            ],
            [
                'name' => 'Menu Config',
                'slug' => 'menu-config',
                'description' => 'Digital menu categories, food items, and modifier groups.',
                'sub_categories' => [
                    ['name' => 'CATEGORIES', 'slug' => 'menu-categories', 'description' => 'Food Menu Categories'],
                    ['name' => 'ITEMS', 'slug' => 'menu-items', 'description' => 'Food Menu Items & Pricing'],
                    ['name' => 'MODIFIERS', 'slug' => 'menu-modifiers', 'description' => 'Add-ons & Modifier Groups'],
                ]
            ],
            [
                'name' => 'Order & POS',
                'slug' => 'order-pos',
                'description' => 'POS billing, Kitchen Orders (KOT), and Table Reservations.',
                'sub_categories' => [
                    ['name' => 'POS BILLING', 'slug' => 'pos-billing', 'description' => 'Point of Sale & Billing Operations'],
                    ['name' => 'KOT (KITCHEN)', 'slug' => 'kot-kitchen', 'description' => 'Kitchen Order Tickets & Displays'],
                    ['name' => 'RESERVATIONS', 'slug' => 'reservations', 'description' => 'Table Reservations & Booking'],
                ]
            ],
            [
                'name' => 'Reports & Billing',
                'slug' => 'reports-billing',
                'description' => 'Sales reports, statements, and subscription package plans.',
                'sub_categories' => [
                    ['name' => 'SALES REPORTS', 'slug' => 'sales-reports', 'description' => 'Sales & Expense Performance Reports'],
                    ['name' => 'BILLING PLANS', 'slug' => 'billing-plans', 'description' => 'Subscription Packages & Billing'],
                ]
            ],
        ];

        foreach ($categoriesData as $catData) {
            $category = TutorialCategory::firstOrCreate(
                ['slug' => $catData['slug']],
                [
                    'name' => $catData['name'],
                    'description' => $catData['description']
                ]
            );

            foreach ($catData['sub_categories'] as $subData) {
                TutorialSubCategory::firstOrCreate(
                    [
                        'tutorial_category_id' => $category->id,
                        'slug' => $subData['slug']
                    ],
                    [
                        'name' => $subData['name'],
                        'description' => $subData['description']
                    ]
                );
            }
        }
    }
}
