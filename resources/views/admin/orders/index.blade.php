@extends('layouts.app')

@section('content')

<div style="max-width:1200px;margin:30px auto;padding:20px;">

    <h1 style="margin-bottom:8px;">🛒 Kelola Pesanan</h1>

    <p style="color:#666;margin-bottom:25px;">
        Kelola status pesanan pelanggan dari pembayaran sampai selesai.
    </p>

    @if(session('success'))
        <div style="
            background:#dcfce7;
            color:#166534;
            padding:14px 18px;
            border-radius:10px;
            margin-bottom:20px;
            font-weight:bold;
        ">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="
            background:#fee2e2;
            color:#991b1b;
            padding:14px 18px;
            border-radius:10px;
            margin-bottom:20px;
        ">
            @foreach($errors->all() as $error)
                <div>❌ {{ $error }}</div>
            @endforeach
        </div>
    @endif

    @php
        use Illuminate\Support\Facades\DB;

        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->get();

        $statusLabels = [
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Sudah Dibayar',
            'processing' => 'Dikemas',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
        ];

        $statusColors = [
            'pending' => '#fef3c7',
            'paid' => '#dcfce7',
            'processing' => '#dbeafe',
            'shipped' => '#ede9fe',
            'completed' => '#d1fae5',
        ];

        $statusTextColors = [
            'pending' => '#92400e',
            'paid' => '#166534',
            'processing' => '#1e40af',
            'shipped' => '#5b21b6',
            'completed' => '#065f46',
        ];
    @endphp

    @forelse($orders as $order)

        @php
            $currentStatus = $order->status ?? 'pending';

            $items = DB::table('order_items')
                ->leftJoin(
                    'books',
                    'order_items.book_id',
                    '=',
                    'books.id'
                )
                ->where(
                    'order_items.order_id',
                    $order->id
                )
                ->select(
                    'order_items.*',
                    'books.title as book_title',
                    'books.image as book_image'
                )
                ->get();
        @endphp

        <div style="
            background:white;
            border-radius:18px;
            padding:22px;
            margin-bottom:25px;
            box-shadow:0 5px 20px rgba(0,0,0,.08);
            border:1px solid #eee;
        ">

            {{-- HEADER PESANAN --}}
            <div style="
                display:flex;
                justify-content:space-between;
                align-items:center;
                gap:15px;
                flex-wrap:wrap;
                margin-bottom:20px;
            ">

                <div>
                    <div style="
                        font-size:20px;
                        font-weight:bold;
                        margin-bottom:5px;
                    ">
                        📦 Pesanan #{{ $order->id }}
                    </div>

                    <div style="color:#666;">
                        User ID: {{ $order->user_id }}
                    </div>
                </div>

                <div style="text-align:right;">

                    <div style="
                        font-size:20px;
                        font-weight:bold;
                        margin-bottom:8px;
                    ">
                        Rp {{ number_format($order->total,0,',','.') }}
                    </div>

                    <span style="
                        display:inline-block;
                        background:{{ $statusColors[$currentStatus] ?? '#f1f5f9' }};
                        color:{{ $statusTextColors[$currentStatus] ?? '#334155' }};
                        padding:7px 13px;
                        border-radius:20px;
                        font-weight:bold;
                    ">
                        {{ $statusLabels[$currentStatus] ?? ucfirst($currentStatus) }}
                    </span>

                </div>

            </div>

            {{-- INFO PEMBAYARAN --}}
            <div style="
                background:#f8fafc;
                border-radius:12px;
                padding:15px;
                margin-bottom:20px;
            ">

                <div style="margin-bottom:6px;">
                    💳 <strong>Metode Pembayaran:</strong>
                    {{ strtoupper($order->payment_method ?? '-') }}
                </div>

                <div>
                    🕐 <strong>Status:</strong>
                    {{ $statusLabels[$currentStatus] ?? ucfirst($currentStatus) }}
                </div>

            </div>

            {{-- TIMELINE --}}
            <div style="
                background:#fafafa;
                border-radius:12px;
                padding:18px;
                margin-bottom:20px;
            ">

                <h3 style="margin-top:0;">
                    🚚 Tracking Pesanan
                </h3>

                @php
                    $timeline = [
                        'pending',
                        'paid',
                        'processing',
                        'shipped',
                        'completed'
                    ];

                    $statusIndex = array_search(
                        $currentStatus,
                        $timeline
                    );

                    if ($statusIndex === false) {
                        $statusIndex = 0;
                    }
                @endphp

                <div style="
                    display:flex;
                    justify-content:space-between;
                    gap:8px;
                    flex-wrap:wrap;
                ">

                    @foreach($timeline as $index => $step)

                        @php
                            $done = $index <= $statusIndex;

                            $label = $statusLabels[$step];

                            if (
                                $step === 'pending' &&
                                ($order->payment_method ?? '') !== 'cod'
                            ) {
                                $label = 'Menunggu Pembayaran';
                            }
                        @endphp

                        <div style="
                            flex:1;
                            min-width:130px;
                            text-align:center;
                        ">

                            <div style="
                                width:38px;
                                height:38px;
                                line-height:38px;
                                margin:0 auto 8px;
                                border-radius:50%;
                                background:{{ $done ? '#22c55e' : '#e5e7eb' }};
                                color:{{ $done ? 'white' : '#777' }};
                                font-weight:bold;
                            ">
                                {{ $done ? '✓' : ($index + 1) }}
                            </div>

                            <div style="
                                font-size:13px;
                                font-weight:{{ $done ? 'bold' : 'normal' }};
                                color:{{ $done ? '#166534' : '#777' }};
                            ">
                                {{ $label }}
                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

            {{-- DAFTAR BUKU --}}
            <div style="margin-bottom:20px;">

                <h3>
                    📚 Buku yang Dipesan
                </h3>

                @forelse($items as $item)

                    <div style="
                        display:flex;
                        align-items:center;
                        gap:15px;
                        padding:12px;
                        border-bottom:1px solid #eee;
                    ">

                        @if(!empty($item->book_image))

                            <img
                                src="{{ asset('img/' . $item->book_image) }}"
                                style="
                                    width:65px;
                                    height:85px;
                                    object-fit:cover;
                                    border-radius:8px;
                                    border:1px solid #ddd;
                                "
                                onerror="this.style.display='none';"
                            >

                        @else

                            <div style="
                                width:65px;
                                height:85px;
                                border-radius:8px;
                                background:#f1f5f9;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                font-size:25px;
                            ">
                                📕
                            </div>

                        @endif

                        <div style="flex:1;">

                            <div style="
                                font-weight:bold;
                                font-size:16px;
                            ">
                                {{ $item->book_title ?? 'Buku tidak ditemukan' }}
                            </div>

                            <div style="
                                color:#666;
                                margin-top:5px;
                            ">
                                Jumlah: {{ $item->qty }}
                            </div>

                            <div style="
                                color:#666;
                                margin-top:3px;
                            ">
                                Harga:
                                Rp {{ number_format($item->price,0,',','.') }}
                            </div>

                        </div>

                        <div style="
                            font-weight:bold;
                            text-align:right;
                        ">
                            Rp {{ number_format($item->subtotal,0,',','.') }}
                        </div>

                    </div>

                @empty

                    <div style="
                        padding:20px;
                        background:#f8fafc;
                        border-radius:10px;
                        color:#777;
                    ">
                        Tidak ada detail buku.
                    </div>

                @endforelse

            </div>

            {{-- TOMBOL STATUS --}}
            <div style="
                border-top:1px solid #eee;
                padding-top:20px;
            ">

                <h3 style="margin-top:0;">
                    ⚙️ Ubah Status Pesanan
                </h3>

                <div style="
                    display:flex;
                    gap:10px;
                    flex-wrap:wrap;
                ">

                    {{-- DIBAYAR --}}
                    @if($currentStatus === 'pending')

                        <form
                            method="POST"
                            action="{{ url('/admin/orders/' . $order->id . '/status') }}"
                        >
                            @csrf

                            <input
                                type="hidden"
                                name="status"
                                value="paid"
                            >

                            <button
                                type="submit"
                                style="
                                    border:none;
                                    background:#22c55e;
                                    color:white;
                                    padding:11px 17px;
                                    border-radius:10px;
                                    font-weight:bold;
                                    cursor:pointer;
                                "
                            >
                                💰 Tandai Dibayar
                            </button>

                        </form>

                    @endif

                    {{-- DIKEMAS --}}
                    @if(in_array($currentStatus, ['paid']))

                        <form
                            method="POST"
                            action="{{ url('/admin/orders/' . $order->id . '/status') }}"
                        >
                            @csrf

                            <input
                                type="hidden"
                                name="status"
                                value="processing"
                            >

                            <button
                                type="submit"
                                style="
                                    border:none;
                                    background:#3b82f6;
                                    color:white;
                                    padding:11px 17px;
                                    border-radius:10px;
                                    font-weight:bold;
                                    cursor:pointer;
                                "
                            >
                                📦 Dikemas
                            </button>

                        </form>

                    @endif

                    {{-- DIKIRIM --}}
                    @if(in_array($currentStatus, ['processing']))

                        <form
                            method="POST"
                            action="{{ url('/admin/orders/' . $order->id . '/status') }}"
                        >
                            @csrf

                            <input
                                type="hidden"
                                name="status"
                                value="shipped"
                            >

                            <button
                                type="submit"
                                style="
                                    border:none;
                                    background:#8b5cf6;
                                    color:white;
                                    padding:11px 17px;
                                    border-radius:10px;
                                    font-weight:bold;
                                    cursor:pointer;
                                "
                            >
                                🚚 Dikirim
                            </button>

                        </form>

                    @endif

                    {{-- SELESAI --}}
                    @if(in_array($currentStatus, ['shipped']))

                        <form
                            method="POST"
                            action="{{ url('/admin/orders/' . $order->id . '/status') }}"
                        >
                            @csrf

                            <input
                                type="hidden"
                                name="status"
                                value="completed"
                            >

                            <button
                                type="submit"
                                style="
                                    border:none;
                                    background:#059669;
                                    color:white;
                                    padding:11px 17px;
                                    border-radius:10px;
                                    font-weight:bold;
                                    cursor:pointer;
                                "
                            >
                                ✅ Selesai
                            </button>

                        </form>

                    @endif

                    {{-- SUDAH SELESAI --}}
                    @if($currentStatus === 'completed')

                        <div style="
                            background:#dcfce7;
                            color:#166534;
                            padding:11px 17px;
                            border-radius:10px;
                            font-weight:bold;
                        ">
                            ✅ Pesanan sudah selesai
                        </div>

                    @endif

                </div>

            </div>

        </div>

    @empty

        <div style="
            background:white;
            padding:50px;
            text-align:center;
            border-radius:18px;
            box-shadow:0 5px 20px rgba(0,0,0,.08);
        ">

            <div style="font-size:50px;margin-bottom:15px;">
                📦
            </div>

            <h2>Belum ada pesanan</h2>

            <p style="color:#777;">
                Pesanan pelanggan akan muncul di sini.
            </p>

        </div>

    @endforelse

</div>

@endsection