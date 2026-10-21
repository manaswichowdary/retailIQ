<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $techParts = Supplier::create(['name' => 'TechParts Co', 'lead_time_days' => 7]);
        $caseWorld = Supplier::create(['name' => 'CaseWorld', 'lead_time_days' => 14]);
        $cableHub = Supplier::create(['name' => 'CableHub', 'lead_time_days' => 10]);

        $products = [
            ['supplier_id' => $techParts->id, 'name' => 'Phone Charger', 'sku' => 'CHG-001', 'category' => 'Chargers', 'price' => 12.99, 'stock' => 60, 'safety_stock' => 5],
            ['supplier_id' => $techParts->id, 'name' => 'Wireless Charger', 'sku' => 'CHG-002', 'category' => 'Chargers', 'price' => 24.99, 'stock' => 8, 'safety_stock' => 4],
            ['supplier_id' => $caseWorld->id, 'name' => 'Phone Case', 'sku' => 'CS-001', 'category' => 'Cases', 'price' => 9.99, 'stock' => 100, 'safety_stock' => 10],
            ['supplier_id' => $caseWorld->id, 'name' => 'Leather Case', 'sku' => 'CS-002', 'category' => 'Cases', 'price' => 19.99, 'stock' => 22, 'safety_stock' => 6],
            ['supplier_id' => $caseWorld->id, 'name' => 'Screen Protector', 'sku' => 'SP-001', 'category' => 'Protectors', 'price' => 7.99, 'stock' => 70, 'safety_stock' => 8],
            ['supplier_id' => $cableHub->id, 'name' => 'USB-C Cable', 'sku' => 'CB-001', 'category' => 'Cables', 'price' => 8.99, 'stock' => 35, 'safety_stock' => 5],
            ['supplier_id' => $cableHub->id, 'name' => 'Lightning Cable', 'sku' => 'CB-002', 'category' => 'Cables', 'price' => 9.99, 'stock' => 12, 'safety_stock' => 5],
            ['supplier_id' => $techParts->id, 'name' => 'Car Mount', 'sku' => 'MT-001', 'category' => 'Accessories', 'price' => 14.99, 'stock' => 45, 'safety_stock' => 4],
        ];

        $weeklySales = [
            'CHG-001' => [12, 16, 14, 18, 15, 17, 14, 16],
            'CHG-002' => [4, 5, 6, 5, 7, 6, 5, 6],
            'CS-001' => [20, 30, 25, 25, 28, 24, 26, 27],
            'CS-002' => [5, 6, 4, 7, 5, 6, 6, 5],
            'SP-001' => [10, 12, 9, 11, 13, 10, 12, 11],
            'CB-001' => [8, 9, 7, 10, 9, 8, 10, 9],
            'CB-002' => [9, 8, 10, 9, 11, 10, 9, 10],
            'MT-001' => [3, 4, 3, 5, 4, 3, 4, 4],
        ];

        foreach ($products as $data) {
            $product = Product::create($data);

            foreach ($weeklySales[$product->sku] as $index => $quantity) {
                Sale::create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'sold_at' => now()->subWeeks(8 - $index),
                ]);
            }
        }
    }
}