@extends('layouts.app')

@section('content')

<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f6f8;
    }

    .container {
        width: 90%;
        max-width: 1000px;
        margin: 40px auto;
    }

    h1 {
        text-align: center;
    }

    .cart-item {
        background: white;
        padding: 20px;
        margin-bottom: 15px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .price {
        font-weight: bold;
    }

    .total {
        background: white;
        padding: 20px;
        border-radius: 12px;
        margin-top: 20px;
        text-align: right;
    }

    .btn {
        padding: 10px 16px;
        border: none;
        border-radius: 7px;
        color: white;
        text-decoration: none;
        cursor: pointer;
    }

    .checkout {
        background: #28a745;
    }

    .delete {
        background: #d32f2f;
    }

    .back {
        background: #222;
    }
</style>

<div class="container">

    <h1>🛒 Keranjang Belanja</h1>

    @if(session('success'))
        <div style="
            background:#d4edda;
            padding:12px;
            border-radius:8px;
            margin-bottom:20px;
        ">
            {{ session('success') }}
        </div>
    @endif


    @if(count($cart) > 0)

        @foreach($cart as $id => $item)

            <div class="cart-item">

                <div>

                    <h2>{{ $item['title'] }}</h2>

                    <p>
                        Penulis: {{ $item['author'] }}
                    </p>

                    <p>
                        Harga:
                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                    </p>

                    <p>
                        Jumlah: {{ $item['quantity'] }}
                    </p>

                    <p class="price">
                        Subtotal:
                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                    </p>

                </div>


                <form action="/cart/remove/{{ $id }}" method="POST">

                    @csrf
                    @method('DELETE')

                    <button class="btn delete">
                        Hapus
                    </button>

                </form>

            </div>

        @endforeach


        <div class="total">

            <h2>
                Total:
                Rp {{ number_format($total, 0, ',', '.') }}
            </h2>

            <a href="/"
               class="btn back">
                ← Kembali
            </a>

            <a href="/checkout"
               class="btn checkout">
                💳 Checkout
            </a>

        </div>

    @else

        <div style="
            background:white;
            padding:40px;
            text-align:center;
            border-radius:12px;
        ">

            <h2>Keranjang masih kosong 😭</h2>

            <a href="/"
               class="btn back">
                ← Kembali ke Buku
            </a>

        </div>

    @endif

</div>

@endsection