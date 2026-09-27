@extends('layouts.app')

@section('content')

<style>
    .orders-container {
        max-width: 1100px;
        margin: 40px auto;
        padding: 20px;
    }

    .orders-title {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 25px;
    }

    .success-box {
        background: #dcfce7;
        color: #166534;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .order-card {
        background: white;
        padding: 25px;
        border-radius: 18px;
        box-shadow: 0 5px 20px rgba(0,0,0,.08);
        margin-bottom: 20px;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .order-number {
        font-size: 20px;
        font-weight: bold;
    }

    .status {
        display: inline-block;
        padding: 7px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .status-paid {
        background: #dcfce7;
        color: #166534;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-processing {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-shipped {
        background: #e0e7ff;
        color: #3730a3;
    }

    .status-completed {
        background: #dcfce7;
        color: #166534;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    .order-info {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    .info-box {
        background: #f8fafc;
        padding: 15px;
        border-radius: 10px;
    }

    .info-label {
        color: #6b7280;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .info-value {
        font-weight: bold;
    }

    .total {
        text-align: right;
        font-size: 22px;
        font-weight: bold;
        color: #15803d;
        margin-top: 15px;
    }

    .empty-box {
        background: white;
        padding: 50px 20px;
        border-radius: 18px;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0,0,0,.08);
    }

    .empty-icon {
        font-size: 60px;
        margin-bottom: 15px;
    }

    .btn-home {
        display: inline-block;
        margin-top: 20px;
        padding: 12px 22px;
        background: #2563eb;
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: bold;
    }

    @media(max-width: 700px) {

        .order-info {
            grid-template-columns: 1fr;
        }

        .order-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .total {
            text-align: left;
        }
    }
</style>


<div class="orders-container">

    <div class="orders-title">
        📦 Pesanan Saya
    </div>


    @if(session('success'))

        <div class="success-box">
            ✅ {{ session('success') }}
        </div>

    @endif


    @if($orders->count() > 0)

        @foreach($orders as $order)

            <div class="order-card">

                <div class="order-header">

                    <div class="order-number">

                        Pesanan #{{ $order->id }}

                    </div>


                    @php

                        $statusClass = match($order->status) {

                            'paid' => 'status-paid',

                            'pending' => 'status-pending',

                            'processing' => 'status-processing',

                            'shipped' => 'status-shipped',

                            'completed' => 'status-completed',

                            'cancelled' => 'status-cancelled',

                            default => 'status-pending',

                        };

                    @endphp


                    <span class="status {{ $statusClass }}">

                        {{ $order->status }}

                    </span>

                </div>


                <div class="order-info">

                    <div class="info-box">

                        <div class="info-label">
                            💳 Metode Pembayaran
                        </div>

                        <div class="info-value">

                            @if($order->payment_method === 'qris')

                                📱 QRIS

                            @elseif($order->payment_method === 'transfer')

                                🏦 Transfer Bank

                            @elseif($order->payment_method === 'cod')

                                💵 COD

                            @else

                                {{ $order->payment_method }}

                            @endif

                        </div>

                    </div>


                    <div class="info-box">

                        <div class="info-label">
                            📅 Tanggal Pesanan
                        </div>

                        <div class="info-value">

                            {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') }}

                        </div>

                    </div>


                    <div class="info-box">

                        <div class="info-label">
                            📊 Status
                        </div>

                        <div class="info-value">

                            @if($order->status === 'paid')

                                ✅ Sudah Dibayar

                            @elseif($order->status === 'pending')

                                ⏳ Menunggu Pembayaran

                            @elseif($order->status === 'processing')

                                📦 Diproses

                            @elseif($order->status === 'shipped')

                                🚚 Dikirim

                            @elseif($order->status === 'completed')

                                🎉 Selesai

                            @elseif($order->status === 'cancelled')

                                ❌ Dibatalkan

                            @else

                                {{ $order->status }}

                            @endif

                        </div>

                    </div>

                </div>


                <div class="total">

                    Total:

                    Rp
                    {{ number_format(
                        $order->total,
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

            </div>

        @endforeach


    @else

        <div class="empty-box">

            <div class="empty-icon">
                📦
            </div>

            <h2>
                Belum Ada Pesanan
            </h2>

            <p>
                Kamu belum memiliki pesanan.
            </p>

            <a
                href="/"
                class="btn-home"
            >
                🏠 Belanja Buku
            </a>

        </div>

    @endif

</div>

@endsection