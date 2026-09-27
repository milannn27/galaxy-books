@extends('layouts.app')

@section('content')

<style>
    .nota-container {
        max-width: 850px;
        margin: 40px auto;
        padding: 20px;
    }

    .nota-card {
        background: white;
        border-radius: 18px;
        padding: 35px;
        box-shadow: 0 5px 25px rgba(0,0,0,.08);
    }

    .nota-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 20px;
        margin-bottom: 25px;
    }

    .nota-title {
        font-size: 30px;
        font-weight: bold;
        margin: 0;
    }

    .nota-subtitle {
        color: #6b7280;
        margin-top: 6px;
    }

    .nota-number {
        text-align: right;
    }

    .nota-number strong {
        font-size: 18px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 25px;
    }

    .info-box {
        background: #f8fafc;
        padding: 18px;
        border-radius: 12px;
    }

    .info-box h3 {
        margin-top: 0;
        margin-bottom: 10px;
    }

    .info-box p {
        margin: 5px 0;
    }

    .status {
        display: inline-block;
        padding: 7px 13px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 13px;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-paid {
        background: #dcfce7;
        color: #166534;
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

    .nota-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .nota-table th,
    .nota-table td {
        padding: 13px 10px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
    }

    .nota-table th {
        background: #f8fafc;
        font-weight: bold;
    }

    .text-right {
        text-align: right !important;
    }

    .total-section {
        margin-top: 20px;
        display: flex;
        justify-content: flex-end;
    }

    .total-box {
        width: 300px;
        background: #f8fafc;
        padding: 18px;
        border-radius: 12px;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        margin: 8px 0;
    }

    .grand-total {
        border-top: 2px solid #d1d5db;
        padding-top: 12px;
        margin-top: 12px;
        font-size: 22px;
        font-weight: bold;
    }

    .button-area {
        display: flex;
        gap: 12px;
        margin-top: 30px;
    }

    .btn {
        text-decoration: none;
        border: none;
        padding: 13px 20px;
        border-radius: 10px;
        font-weight: bold;
        cursor: pointer;
        font-size: 15px;
        display: inline-block;
    }

    .btn-payment {
        background: #2563eb;
        color: white;
    }

    .btn-orders {
        background: #e5e7eb;
        color: #111827;
    }

    .btn-print {
        background: #16a34a;
        color: white;
    }

    .thank-you {
        text-align: center;
        margin-top: 30px;
        color: #6b7280;
    }

    @media(max-width: 700px) {
        .nota-header {
            flex-direction: column;
            gap: 15px;
        }

        .nota-number {
            text-align: left;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .nota-card {
            padding: 20px;
        }

        .nota-table {
            font-size: 13px;
        }

        .button-area {
            flex-direction: column;
        }

        .btn {
            text-align: center;
        }
    }

    @media print {
        body {
            background: white !important;
        }

        .nota-container {
            margin: 0;
            max-width: 100%;
        }

        .nota-card {
            box-shadow: none;
            border-radius: 0;
        }

        .button-area,
        nav,
        header,
        footer {
            display: none !important;
        }
    }
</style>

<div class="nota-container">

    <div class="nota-card">

        <div class="nota-header">

            <div>
                <h1 class="nota-title">
                    🧾 NOTA PEMBELIAN
                </h1>

                <div class="nota-subtitle">
                    Galaxy Books
                </div>
            </div>

            <div class="nota-number">

                <div>
                    Nomor Pesanan
                </div>

                <strong>
                    #{{ $order->id }}
                </strong>

                <div style="margin-top: 8px; color:#6b7280;">
                    {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}
                </div>

            </div>

        </div>


        <div class="info-grid">

            <div class="info-box">

                <h3>👤 Data Pembeli</h3>

                <p>
                    <strong>Nama:</strong>
                    {{ auth()->user()->name ?? 'Pembeli' }}
                </p>

                <p>
                    <strong>Email:</strong>
                    {{ auth()->user()->email ?? '-' }}
                </p>

            </div>


            <div class="info-box">

                <h3>💳 Pembayaran</h3>

                <p>
                    <strong>Metode:</strong>

                    @if($order->payment_method === 'qris')
                        📱 QRIS
                    @elseif($order->payment_method === 'transfer')
                        🏦 Transfer Bank
                    @elseif($order->payment_method === 'cod')
                        💵 COD
                    @else
                        {{ strtoupper($order->payment_method) }}
                    @endif
                </p>

                <p>
                    <strong>Status:</strong>

                    @if($order->status === 'pending')

                        <span class="status status-pending">
                            Menunggu Pembayaran
                        </span>

                    @elseif($order->status === 'paid')

                        <span class="status status-paid">
                            Sudah Dibayar
                        </span>

                    @elseif($order->status === 'processing')

                        <span class="status status-processing">
                            Dikemas
                        </span>

                    @elseif($order->status === 'shipped')

                        <span class="status status-shipped">
                            Dikirim
                        </span>

                    @elseif($order->status === 'completed')

                        <span class="status status-completed">
                            Selesai
                        </span>

                    @else

                        <span class="status">
                            {{ ucfirst($order->status) }}
                        </span>

                    @endif

                </p>

            </div>

        </div>


        <h2>
            📦 Detail Pesanan
        </h2>


        <table class="nota-table">

            <thead>

                <tr>
                    <th>No</th>
                    <th>Buku</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th class="text-right">Subtotal</th>
                </tr>

            </thead>

            <tbody>

                @foreach($items as $index => $item)

                    <tr>

                        <td>
                            {{ $index + 1 }}
                        </td>

                        <td>
                            <strong>
                                {{ $item->book_title ?? 'Buku' }}
                            </strong>
                        </td>

                        <td>
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </td>

                        <td>
                            {{ $item->qty }}
                        </td>

                        <td class="text-right">

                            Rp
                            {{ number_format(
                                $item->subtotal,
                                0,
                                ',',
                                '.'
                            ) }}

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>


        <div class="total-section">

            <div class="total-box">

                <div class="total-row">

                    <span>
                        Total Barang
                    </span>

                    <span>
                        {{ $items->sum('qty') }} buku
                    </span>

                </div>


                <div class="total-row grand-total">

                    <span>
                        TOTAL
                    </span>

                    <span>
                        Rp
                        {{ number_format(
                            $order->total,
                            0,
                            ',',
                            '.'
                        ) }}
                    </span>

                </div>

            </div>

        </div>


        <div class="button-area">

            @if($order->status === 'pending')

                <a
                    href="{{ url('/payment/' . $order->id) }}"
                    class="btn btn-payment"
                >
                    💳 Lanjut ke Pembayaran
                </a>

            @endif


            <a
                href="{{ url('/orders') }}"
                class="btn btn-orders"
            >
                📦 Pesanan Saya
            </a>


            <button
                type="button"
                onclick="window.print()"
                class="btn btn-print"
            >
                🖨️ Cetak Nota
            </button>

        </div>


        <div class="thank-you">

            <strong>
                Terima kasih sudah berbelanja di Galaxy Books! 📚
            </strong>

            <br>

            Simpan nota ini sebagai bukti pembelian.

        </div>

    </div>

</div>

@endsection