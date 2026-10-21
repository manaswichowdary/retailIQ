<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with('product:id,name,sku')->latest('sold_at');

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('weeks')) {
            $query->where('sold_at', '>=', now()->subWeeks((int) $request->weeks));
        }

        return $query->get();
    }
}