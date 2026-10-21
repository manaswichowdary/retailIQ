<?php

namespace App\Services;

use App\Models\Product;

class ReorderService
{
    private const WEEKS_OF_HISTORY = 4;

    public function weeklyAverage(Product $product): float
    {
        $quantities = $product->sales()
            ->latest('sold_at')
            ->take(self::WEEKS_OF_HISTORY)
            ->pluck('quantity');

        return $quantities->isEmpty() ? 0.0 : (float) $quantities->avg();
    }

    public function reorderPoint(Product $product): int
    {
        $weeksOfWaiting = $product->supplier->lead_time_days / 7;

        return (int) ceil(
            ($this->weeklyAverage($product) * $weeksOfWaiting) + $product->safety_stock
        );
    }

    public function analyze(Product $product): array
    {
        $reorderPoint = $this->reorderPoint($product);

        return [
            'product_id' => $product->id,
            'name' => $product->name,
            'stock' => $product->stock,
            'weekly_average' => round($this->weeklyAverage($product), 2),
            'lead_time_days' => $product->supplier->lead_time_days,
            'safety_stock' => $product->safety_stock,
            'reorder_point' => $reorderPoint,
            'needs_reorder' => $product->stock <= $reorderPoint,
        ];
    }
}