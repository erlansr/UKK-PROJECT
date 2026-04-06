<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)
                        ->where('stock', '>', 0);
        
        // Filter pencarian
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        // Sorting - FIXED
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }
        
        $products = $query->paginate(12);
        
        // Menjaga query string saat pagination
        $products->appends($request->only(['search', 'sort']));
        
        return view('products.index', compact('products'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
                         ->where('is_active', true)
                         ->firstOrFail();
        
        // Rekomendasi produk terkait (opsional)
        $relatedProducts = Product::where('is_active', true)
                                  ->where('stock', '>', 0)
                                  ->where('id', '!=', $product->id)
                                  ->limit(4)
                                  ->get();
        
        return view('products.show', compact('product', 'relatedProducts'));
    }
}