<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ReorderService;

class ReorderController extends Controller
{
    public function index(ReorderService $reorders)
    {
        return Product::with('supplier')->get()
            ->map(fn (Product $product) => $reorders->analyze($product))
            ->sortByDesc('needs_reorder')
            ->values();
    }
}