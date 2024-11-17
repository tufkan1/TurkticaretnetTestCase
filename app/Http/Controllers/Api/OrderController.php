<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->get();
        return response()->json($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        // Kullanıcının aktif sepetini al
        $cart = Cart::where('user_id', $user->id)->where('status', 'active')->first();


        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Sepet boş yada bulunamadı'], 400);
        }

        // Stok kontrolü
        foreach ($cart->items as $item) {
            if ($item->quantity > $item->product->stock) {
                return response()->json([
                    'message' => 'İlgili üründe yeterli stok bulunmamaktadır: ' . $item->product->name
                ], 400);
            }
        }

        // Sipariş oluştur
        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $cart->items->sum(fn($item) => $item->quantity * $item->price),
            'status' => 'pending', // Varsayılan sipariş durumu
        ]);

        // Stokları güncelle
        foreach ($cart->items as $item) {
            $item->product->decrement('stock', $item->quantity);
        }

        // Sepeti tamamlanmış olarak işaretle
        $cart->update(['status' => 'completed']);

        return response()->json(['message' => 'Sipariş oluşturuldu', 'order' => $order], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = auth()->user();

        $order = Order::where('user_id', $user->id)
            ->where('id', $id)
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Sipariş bulunamadı.'], 404);
        }

        return response()->json($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }
}
