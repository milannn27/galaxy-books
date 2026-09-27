@extends('layouts.app')

@section('content')

<style>
    .checkout-container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 20px;
    }

    .checkout-title {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 25px;
    }

    .checkout-grid {
        display: grid;
        grid-template-columns: 1.3fr .7fr;
        gap: 25px;
    }

    .checkout-card {
        background: white;
        padding: 25px;
        border-radius: 18px;
        box-shadow: 0 5px 20px rgba(0,0,0,.08);
        margin-bottom: 20px;
    }

    .checkout-card h2 {
        margin-top: 0;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 7px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 12px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        font-size: 15px;
    }

    .form-group textarea {
        min-height: 100px;
        resize: vertical;
    }

    .payment-option {
        display: block;
        padding: 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 12px;
        cursor: pointer;
    }

    .payment-option:hover {
        border-color: #2563eb;
        background: #f8fafc;
    }

    .payment-option input {
        margin-right: 10px;
    }

    .payment-title {
        font-weight: bold;
        font-size: 17px;
    }

    .payment-desc {
        display: block;
        margin-left: 25px;
        margin-top: 4px;
        color: #6b7280;
        font-size: 13px;
    }

    .checkout-item {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }

    .total-box {
        font-size: 22px;
        font-weight: bold;
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
    }

    .btn-order {
        width: 100%;
        border: none;
        background: #16a34a;
        color: white;
        padding: 15px;
        border-radius: 12px;
        font-size: 17px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 20px;
    }

    .btn-order:hover {
        background: #15803d;
    }

    .error-box {
        background: #fee2e2;
        color: #991b1b;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .success-box {
        background: #dcfce7;
        color: #166534;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    @media(max-width: 800px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="checkout-container">

    <div class="checkout-title">
        🛒 Checkout Galaxy Books
    </div>

    @if(session('success'))
        <div class="success-box">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="error-box">

            <strong>Periksa data:</strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif


    <form action="{{ url('/checkout') }}" method="POST">

        @csrf

        <div class="checkout-grid">

            <div>

                <div class="checkout-card">

                    <h2>👤 Data Pembeli</h2>

                    <div class="form-group">

                        <label>
                            Nama Lengkap
                        </label>

                        <input
                            type="text"
                            name="customer_name"
                            value="{{ old('customer_name', auth()->user()->name ?? '') }}"
                            placeholder="Masukkan nama lengkap"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Nomor WhatsApp
                        </label>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="08xxxxxxxxxx"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Alamat Pengiriman
                        </label>

                        <textarea
                            name="address"
                            placeholder="Masukkan alamat lengkap"
                            required
                        >{{ old('address') }}</textarea>

                    </div>

                </div>


                <div class="checkout-card">

                    <h2>
                        💳 Metode Pembayaran
                    </h2>


                    <label class="payment-option">

                        <input
                            type="radio"
                            name="payment_method"
                            value="qris"
                            {{ old('payment_method', 'qris') == 'qris' ? 'checked' : '' }}
                            required
                        >

                        <span class="payment-title">
                            📱 QRIS
                        </span>

                        <span class="payment-desc">
                            Bayar menggunakan QRIS.
                        </span>

                    </label>


                    <label class="payment-option">

                        <input
                            type="radio"
                            name="payment_method"
                            value="transfer"
                            {{ old('payment_method') == 'transfer' ? 'checked' : '' }}
                        >

                        <span class="payment-title">
                            🏦 Transfer Bank
                        </span>

                        <span class="payment-desc">
                            Pembayaran melalui transfer bank.
                        </span>

                    </label>


                    <label class="payment-option">

                        <input
                            type="radio"
                            name="payment_method"
                            value="cod"
                            {{ old('payment_method') == 'cod' ? 'checked' : '' }}
                        >

                        <span class="payment-title">
                            💵 COD
                        </span>

                        <span class="payment-desc">
                            Bayar ketika pesanan diterima.
                        </span>

                    </label>

                </div>

            </div>


            <div>

                <div class="checkout-card">

                    <h2>
                        📦 Ringkasan Pesanan
                    </h2>


                    @foreach($cart as $item)

                        <div class="checkout-item">

                            <div>

                                <strong>
                                    {{ $item['title'] }}
                                </strong>

                                <div
                                    style="
                                        color:#6b7280;
                                        font-size:13px;
                                    "
                                >

                                    {{ $item['quantity'] }} ×

                                    Rp
                                    {{ number_format(
                                        $item['price'],
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </div>

                            </div>


                            <strong>

                                Rp
                                {{ number_format(
                                    $item['price'] * $item['quantity'],
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </strong>

                        </div>

                    @endforeach


                    <div class="total-box">

                        <span>
                            Total
                        </span>

                        <span>

                            Rp
                            {{ number_format(
                                $total,
                                0,
                                ',',
                                '.'
                            ) }}

                        </span>

                    </div>


                    <button
                        type="submit"
                        class="btn-order"
                    >
                        💳 Lanjut ke Pembayaran
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection