<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class ProductController extends Controller
{
    // Tüm ürünleri getir (package bilgisiyle birlikte)
    public function getAllProducts(Request $request)
    {
        $products = Product::with('package')->get();
        return response()->json($products);
    }

    // Organization name ile ürün getir (package bilgisiyle)
    public function getProductsByOrganizationName(Request $request)
    {
        $validatedData = $request->validate([
            'organization_name' => 'required|string',
        ]);

        $products = Product::where('organization_name', $validatedData['organization_name'])
            ->with('package')
            ->get();

        return response()->json($products, 200);
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
            'user_id' => 'required|string',
            'package_id' => 'required|string',
            'organization_name' => 'nullable|string',
            'organization_type' => 'required|string',
            'bride_name' => 'required|string',
            'groom_name' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string',
            'folder_name' => 'required|string',
            'freeSpace' => 'nullable|integer',
            'fullSpace' => 'nullable|integer',
            'usedSpace' => 'nullable|integer',
            'email' => 'nullable|email',  // Email alanı eklendi
            'phone' => 'nullable|string', // Telefon alanı eklendi
            'guests_count' => 'nullable|integer', // guests_count alanı eklendi
            'description' => 'nullable|string',    // description alanı eklendi

        ]);

        $product = Product::create($validatedData);
        return response()->json($product, 201);
    }

    // Email ile ürün getir (package bilgisiyle)
    public function getProductByEmail(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
        ]);

        // Belirtilen e-posta adresine sahip ürünleri al
        $products = Product::where('email', $validatedData['email'])->with('package')->get();

        // Eğer ürün yoksa uygun bir mesaj döndür
        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found for this email.'], 404);
        }

        return response()->json($products);
    }
}
