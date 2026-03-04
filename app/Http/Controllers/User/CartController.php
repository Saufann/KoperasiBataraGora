<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    /**
     * Tampilkan halaman cart
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        return view('user.cart', compact('cart','total'));
    }


    /**
     * Tambah ke cart
     */
    public function add(Request $request, $id)
    {
        $product = DB::table('products')->where('id',$id)->first();

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $qty = (int) $request->input('qty', 1);
        if ($qty < 1) {
            return redirect()->back()->with('error', 'Jumlah produk minimal 1.');
        }

        $cart = session()->get('cart', []);
        $currentQty = isset($cart[$id]) ? (int) $cart[$id]['qty'] : 0;
        $newQty = $currentQty + $qty;
        $stock = isset($product->stock) ? (int) $product->stock : null;

        if ($stock !== null && $stock <= 0) {
            return redirect()->back()->with('error', 'Stok produk habis.');
        }

        $message = 'Produk ditambahkan ke keranjang';

        if ($stock !== null && $newQty > $stock) {
            $newQty = $stock;

            if ($newQty <= $currentQty) {
                return redirect()->back()->with('error', 'Jumlah di keranjang sudah mencapai batas stok.');
            }

            $message = 'Jumlah produk disesuaikan dengan stok yang tersedia.';
        }

        if(isset($cart[$id])) {

            $cart[$id]['qty'] = $newQty;

        } else {

            $cart[$id] = [
                "id" => $product->id,
                "name" => $product->name,
                "price" => $product->price,
                "image" => $product->image,
                "qty" => $newQty
            ];

        }

        session()->put('cart',$cart);

        return redirect()->back()->with('success', $message);
    }


    /**
     * Hapus item
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {

            unset($cart[$id]);

            session()->put('cart',$cart);
        }

        return redirect()->back();
    }


    /**
     * Update qty
     */
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $qty = (int) $request->input('qty', 1);

        if ($qty < 1) {
            return redirect()->back()->with('error', 'Jumlah produk minimal 1.');
        }

        if(isset($cart[$id])) {
            $product = DB::table('products')->where('id', $id)->first();
            $stock = $product && isset($product->stock) ? (int) $product->stock : null;

            if ($stock !== null && $qty > $stock) {
                return redirect()->back()->with('error', 'Jumlah melebihi stok yang tersedia.');
            }

            $cart[$id]['qty'] = $qty;

            session()->put('cart',$cart);
        }

        return redirect()->back();
    }


    public function checkout()
    {
        if (!auth()->check()) {
            return redirect()
                ->route('user.landing')
                ->with('error', 'Silakan login terlebih dahulu untuk checkout.');
        }

        $cart = session()->get('cart', []);

        if(empty($cart)){
            return redirect()
                ->route('user.cart')
                ->with('error','Cart kosong');
        }

        DB::beginTransaction();

        try {

            $total = 0;
            $preparedItems = [];

            foreach($cart as $item){
                $product = DB::table('products')
                    ->where('id', $item['id'])
                    ->lockForUpdate()
                    ->first();

                if (!$product) {
                    throw new \RuntimeException('Salah satu produk di keranjang sudah tidak tersedia.');
                }

                $qty = (int) ($item['qty'] ?? 0);
                if ($qty < 1) {
                    throw new \RuntimeException("Jumlah produk {$product->name} tidak valid.");
                }

                if ((int) $product->stock < $qty) {
                    throw new \RuntimeException("Stok {$product->name} tidak mencukupi. Tersisa {$product->stock}.");
                }

                $price = (int) ($item['price'] ?? $product->price ?? 0);
                $total += $price * $qty;

                $preparedItems[] = [
                    'product_id' => $product->id,
                    'qty' => $qty,
                    'price' => $price,
                ];
            }

            $user_id = (int) auth()->id();

            if ($user_id < 1 || !DB::table('users')->where('id', $user_id)->exists()) {
                throw new \RuntimeException('Akun pengguna tidak valid. Silakan login ulang.');
            }

            $order_id = DB::table('orders')->insertGetId([
                'user_id'=>$user_id,
                'total'=>$total,
                'metode'=>'Cash',
                'status'=>'MENUNGGU',
                'created_at'=>now(),
                'updated_at'=>now()
            ]);

            foreach($preparedItems as $item){
                DB::table('order_items')->insert([
                    'order_id'=>$order_id,
                    'product_id'=>$item['product_id'],
                    'qty'=>$item['qty'],
                    'price'=>$item['price'],
                    'created_at'=>now(),
                    'updated_at'=>now()
                ]);

                DB::table('products')
                    ->where('id',$item['product_id'])
                    ->decrement('stock',$item['qty']);
            }

            DB::commit();

            session()->forget('cart');

            return redirect()
                ->route('user.riwayat')
                ->with('success','Checkout berhasil. Pesanan Anda sudah masuk.');

        } catch(\Exception $e){

            DB::rollback();

            return redirect()
                ->route('user.cart')
                ->with('error', $e->getMessage());

        }
    }

}
