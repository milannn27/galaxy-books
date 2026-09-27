@extends('layouts.app')

@section('content')

<style>
    .payment-container {
        max-width: 850px;
        margin: 40px auto;
        padding: 20px;
    }

    .payment-card {
        background: white;
        padding: 35px;
        border-radius: 20px;
        box-shadow: 0 6px 25px rgba(0,0,0,.10);
        margin-bottom: 20px;
    }

    .payment-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .payment-header .icon {
        font-size: 65px;
    }

    .payment-header h1 {
        margin: 10px 0;
        font-size: 32px;
    }

    .order-number {
        color: #6b7280;
    }

    .total-payment {
        background: #f0fdf4;
        border: 2px solid #86efac;
        padding: 20px;
        border-radius: 15px;
        text-align: center;
        margin-bottom: 25px;
    }

    .total-payment small {
        display: block;
        color: #6b7280;
        margin-bottom: 5px;
    }

    .total-payment strong {
        font-size: 32px;
        color: #15803d;
    }

    .qris-box {
        text-align: center;
        padding: 20px;
    }

    .qris-box h2 {
        margin-bottom: 10px;
    }

    .qris-image {
        display: block;
        width: 300px;
        max-width: 100%;
        margin: 20px auto;
        border-radius: 15px;
        border: 1px solid #ddd;
        padding: 10px;
        background: white;
    }

    .instruction {
        background: #f8fafc;
        padding: 18px;
        border-radius: 12px;
        margin-top: 20px;
        line-height: 1.7;
    }

    .bank-box {
        background: #eff6ff;
        padding: 20px;
        border-radius: 12px;
        margin-top: 20px;
    }

    .bank-box p {
        margin: 8px 0;
    }

    .confirm-btn {
        width: 100%;
        border: none;
        background: #16a34a;
        color: white;
        padding: 16px;
        border-radius: 12px;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 25px;
    }

    .confirm-btn:hover {
        background: #15803d;
    }

    .warning {
        background: #fef3c7;
        color: #92400e;
        padding: 15px;
        border-radius: 10px;
        margin-top: 20px;
        text-align: center;
    }

    .back-btn {
        display: inline-block;
        margin-top: 15px;
        color: #2563eb;
        text-decoration: none;
    }
</style>


<div class="payment-container">


    <div class="payment-card">

        <div class="payment-header">

            <div class="icon">
                💳
            </div>

            <h1>
                Pembayaran
            </h1>

            <div class="order-number">

                Pesanan #{{ $order->id }}

            </div>

        </div>


        <div class="total-payment">

            <small>
                Total yang harus dibayar
            </small>

            <strong>

                Rp
                {{ number_format(
                    $order->total,
                    0,
                    ',',
                    '.'
                ) }}

            </strong>

        </div>


        @if($order->payment_method === 'qris')

            <div class="qris-box">

                <h2>
                    📱 Bayar dengan QRIS
                </h2>

                <p>
                    Scan QRIS di bawah menggunakan
                    aplikasi pembayaran kamu.
                </p>


                @if(
                    $paymentSetting &&
                    !empty($paymentSetting->qris_image) &&
                    file_exists(
                        public_path(
                            'img/' .
                            $paymentSetting->qris_image
                        )
                    )
                )

                    <img
                        src="{{ asset(
                            'img/' .
                            $paymentSetting->qris_image
                        ) }}"
                        class="qris-image"
                        alt="QRIS Galaxy Books"
                    >

                @elseif(
                    file_exists(
                        public_path('img/qris.png')
                    )
                )

                    <img
                        src="{{ asset('img/qris.png') }}"
                        class="qris-image"
                        alt="QRIS Galaxy Books"
                    >

                @else

                    <div class="warning">

                        ⚠️ QRIS belum tersedia.

                        <br>

                        Silakan gunakan metode
                        pembayaran lainnya.

                    </div>

                @endif


                <div class="instruction">

                    <strong>
                        Cara pembayaran:
                    </strong>

                    <br>

                    1. Buka aplikasi pembayaran
                    seperti DANA, GoPay, OVO,
                    ShopeePay, atau mobile banking.

                    <br>

                    2. Pilih menu Scan / QRIS.

                    <br>

                    3. Scan QRIS di atas.

                    <br>

                    4. Masukkan nominal:

                    <strong>
                        Rp
                        {{ number_format(
                            $order->total,
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>

                    <br>

                    5. Selesaikan pembayaran.

                    <br>

                    6. Setelah berhasil,
                    klik tombol
                    <strong>
                        "Saya Sudah Bayar"
                    </strong>.

                </div>

            </div>


        @elseif($order->payment_method === 'transfer')

            <div class="qris-box">

                <h2>
                    🏦 Transfer Bank
                </h2>

                <p>
                    Silakan transfer sesuai total
                    pembayaran.
                </p>


                <div class="bank-box">

                    @if($paymentSetting)

                        <p>
                            <strong>
                                Bank:
                            </strong>

                            {{ $paymentSetting->bank_name ?? '-' }}
                        </p>

                        <p>
                            <strong>
                                Nomor Rekening:
                            </strong>

                            {{ $paymentSetting->account_number ?? '-' }}
                        </p>

                        <p>
                            <strong>
                                Atas Nama:
                            </strong>

                            {{ $paymentSetting->account_holder ?? '-' }}
                        </p>

                    @else

                        <p>
                            Data rekening belum
                            diatur admin.
                        </p>

                    @endif

                    <p>
                        <strong>
                            Jumlah:
                        </strong>

                        Rp
                        {{ number_format(
                            $order->total,
                            0,
                            ',',
                            '.'
                        ) }}
                    </p>

                </div>

            </div>


        @elseif($order->payment_method === 'cod')

            <div class="qris-box">

                <h2>
                    💵 Cash On Delivery
                </h2>

                <p>
                    Kamu memilih pembayaran
                    saat barang diterima.
                </p>

                <div class="instruction">

                    Siapkan uang sebesar:

                    <br>

                    <strong>
                        Rp
                        {{ number_format(
                            $order->total,
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>

                    <br><br>

                    Klik tombol di bawah untuk
                    menyelesaikan konfirmasi pesanan.

                </div>

            </div>

        @endif


        <form
            action="{{ url(
                '/payment/' .
                $order->id .
                '/confirm'
            ) }}"
            method="POST"
        >

            @csrf

            <button
                type="submit"
                class="confirm-btn"
            >
                ✅ Saya Sudah Bayar
            </button>

        </form>


        <div style="text-align:center;">

            <a
                href="{{ url('/orders') }}"
                class="back-btn"
            >
                ← Lihat Pesanan
            </a>

        </div>

    </div>

</div>

@endsection