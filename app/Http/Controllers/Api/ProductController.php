<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $products = Product::all();

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $data = $request->validated();

        $product = Auth::user()->products()->create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
        ]);

        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }
}
