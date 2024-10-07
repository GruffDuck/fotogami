<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Tüm ürünleri getir (package bilgisiyle birlikte)
    public function getAllProducts(Request $request)
    {
        $products = Product::with('package')->get();
        return response()->json($products);
    }

    // Organization ID ile ürün getir (package bilgisiyle)
    public function getProductByOrganization(Request $request)
    {
        $organizationId = $request->input('organization_id');

        if (!$organizationId) {
            return response()->json(['error' => 'Organization ID is required'], 400);
        }

        $products = Product::where('organization_id', $organizationId)->with('package')->get();
        return response()->json($products);
    }

    // User ID ile ürün getir (package bilgisiyle)
    public function getProductByUser(Request $request)
    {
        $userId = $request->input('user_id');

        if (!$userId) {
            return response()->json(['error' => 'User ID is required'], 400);
        }

        $products = Product::where('user_id', $userId)->with('package')->get();
        return response()->json($products);
    }

    // Package ID ile ürün getir (package bilgisiyle)
    public function getProductByPackage(Request $request)
    {
        $packageId = $request->input('package_id');

        if (!$packageId) {
            return response()->json(['error' => 'Package ID is required'], 400);
        }

        $products = Product::where('package_id', $packageId)->with('package')->get();
        return response()->json($products);
    }

    // Ürün ekle ve eklenen ürünü dön
    public function createProduct(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'package_id' => 'required|exists:packages,id',
            'organization_id' => 'nullable',
            'organization_type' => 'required|string',
            'bride_name' => 'required|string',
            'groom_name' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string',
            'folder_name' => 'required|string',
        ]);

        $product = Product::create($validatedData);
        $product->load('package'); // Package ilişkisini de yükle

        return response()->json($product, 201);
    }
}
