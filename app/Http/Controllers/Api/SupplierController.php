<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        return Supplier::withCount('products')->get();
    }

    public function show(Supplier $supplier)
    {
        return $supplier->load('products');
    }
}