<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN CHECKOUT
    |--------------------------------------------------------------------------
    */

    public function checkout()
    {
        if (!auth()->check()) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu untuk checkout.');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect('/cart')
                ->with('error', 'Keranjang masih kosong.');
        }

        $total = 0;

        foreach ($cart as $id => $item) {
            $book = Book::find($id);

            if (!$book) {
                continue;
            }

            $price = $this->getFinalPrice($book);

            $cart[$id]['price'] = $price;
            $cart[$id]['title'] = $book->title;
            $cart[$id]['author'] = $book->author;
            $cart[$id]['image'] = $book->image;

            $total += $price * $item['quantity'];
        }

        session()->put('cart', $cart);

        return view('books.checkout', compact('cart', 'total'));
    }


    /*
    |--------------------------------------------------------------------------
    | PROSES PESANAN
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'address' => 'required|string',
            'payment_method' => 'required|in:qris,transfer,cod',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect('/cart')
                ->with('error', 'Keranjang masih kosong.');
        }

        DB::beginTransaction();

        try {

            $total = 0;
            $items = [];

            foreach ($cart as $bookId => $item) {

                $book = Book::lockForUpdate()->find($bookId);

                if (!$book) {
                    throw new \Exception('Buku tidak ditemukan.');
                }

                $qty = (int) $item['quantity'];

                if ($qty <= 0) {
                    throw new \Exception('Jumlah buku tidak valid.');
                }

                if ($book->stock < $qty) {
                    throw new \Exception(
                        'Stok buku "' . $book->title .
                        '" tidak mencukupi. Stok tersedia: ' .
                        $book->stock
                    );
                }

                $price = $this->getFinalPrice($book);
                $subtotal = $price * $qty;

                $total += $subtotal;

                $items[] = [
                    'book' => $book,
                    'qty' => $qty,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | BUAT ORDER
            |--------------------------------------------------------------------------
            */

            $order = new Order();

            $order->user_id = auth()->id();
            $order->total = $total;
            $order->payment_method = $request->payment_method;
            $order->payment_status = 'pending';
            $order->status = 'pending';
            $order->customer_name = $request->customer_name;
            $order->phone = $request->phone;
            $order->address = $request->address;

            $order->save();


            /*
            |--------------------------------------------------------------------------
            | SIMPAN ITEM + KURANGI STOK
            |--------------------------------------------------------------------------
            */

            foreach ($items as $item) {

                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $item['book']->id,
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);

                $item['book']->stock -= $item['qty'];
                $item['book']->save();
            }

            DB::commit();

            session()->forget('cart');

            return redirect('/payment/' . $order->id)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | HALAMAN PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    public function payment($id)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $order = Order::with('items.book')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('books.payment', compact('order'));
    }


    /*
    |--------------------------------------------------------------------------
    | KONFIRMASI PEMBAYARAN USER
    |--------------------------------------------------------------------------
    */

    public function confirmPayment($id)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $order = Order::where('user_id', auth()->id())
            ->findOrFail($id);

        $order->payment_status = 'paid';
        $order->status = 'processing';
        $order->save();

        return redirect('/orders')
            ->with(
                'success',
                'Pembayaran berhasil dikirim. Menunggu konfirmasi admin.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DAFTAR PESANAN USER
    |--------------------------------------------------------------------------
    */

    public function orders()
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $orders = Order::with('items.book')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('books.orders', compact('orders'));
    }


    /*
    |--------------------------------------------------------------------------
    | HITUNG HARGA SETELAH DISKON
    |--------------------------------------------------------------------------
    */

    private function getFinalPrice($book)
    {
        $price = (float) $book->price;

        $discount = (float) ($book->discount_percent ?? 0);

        if ($discount <= 0) {
            return $price;
        }

        $now = now();

        if (
            $book->discount_start &&
            $now->lt($book->discount_start)
        ) {
            return $price;
        }

        if (
            $book->discount_end &&
            $now->gt($book->discount_end)
        ) {
            return $price;
        }

        return $price - ($price * $discount / 100);
    }
}