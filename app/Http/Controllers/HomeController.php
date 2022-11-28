<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // $products = Product::all();
        $products = Product::where('name', 'like', '%' . $request->search . '%')->get();

        return view('home', [
            'products' => $products

        ]);

        $products = $products->paginate(2);
    }
}
