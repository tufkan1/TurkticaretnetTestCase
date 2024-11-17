<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cart = auth()->user()->cart()->firstOrCreate(['status' => 'active']);

        $productId = $request->query('product_id');
        $quantity = $request->query('quantity');
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['error' => 'Ürün bulunamadı'], 404);
        }

        if ($product->stock < $quantity) {
            return response()->json(['error' => 'Yeterli stok bulunmamaktadır'], 400);
        }

        // Sepette aynı ürün varsa miktarı artır
        $cartItem = $cart->items()->where('product_id', $productId)->first();
        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }

        return response()->json($cartItem, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // CartItem'ı bul
        $cartItem = CartItem::find($id);

        if (!$cartItem) {
            return response()->json(['error' => 'Sepet öğesi bulunamadı'], 404);
        }

        $product = $cartItem->product;

        $newQuantity = $request->input('quantity');

        if ($product->stock < $newQuantity) {
            return response()->json(['error' => 'Yeterli stok bulunmamaktadır'], 400);
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->save();

        return response()->json($cartItem);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // CartItem'ı bul
        $cartItem = CartItem::find($id);

        if (!$cartItem) {
            return response()->json(['error' => 'Sepet öğesi bulunamadı'], 404);
        }

        $cartItem->delete();
        return response()->json(['message' => 'Ürün sepetten silindi.']);
    }

}
