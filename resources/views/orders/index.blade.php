@extends('layouts.app')

@section('content')

<div style="
    max-width:1100px;
    margin:30px auto;
    padding:20px;
">

    <h1 style="
        font-size:30px;
        margin-bottom:8px;
    ">
        📦 Pesanan Saya
    </h1>

    <p style="
        color:#666;
        margin-bottom:25px;
    ">
        Lihat status, lacak pesanan, dan beri penilaian setelah pesanan selesai.
    </p>

    @if(session('success'))
        <div style="
            background:#dcfce7;
            color:#166534;
            padding:14px 18px;
            border-radius:12px;
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
            border-radius:12px;
            margin-bottom:20px;
        ">
            @foreach($errors->all() as $error)
                <div>❌ {{ $error }}</div>
            @endforeach
        </div>
    @endif

    @forelse($orders as $order)

        @php
            $status = $order->status ?? 'pending';

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

            $timeline = [
                'pending',
                'paid',
                'processing',
                'shipped',
                'completed'
            ];

            $statusIndex = array_search($status, $timeline);

            if ($statusIndex === false) {
                $statusIndex = 0;
            }
        @endphp

        <div style="
            background:white;
            border-radius:18px;
            padding:22px;
            margin-bottom:25px;
            box-shadow:0 5px 20px rgba(0,0,0,.08);
            border:1px solid #eee;
        ">

            {{-- HEADER --}}
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

                    <div style="color:#777;">
                        {{ $order->created_at ?? '' }}
                    </div>
                </div>

                <div style="text-align:right;">

                    <div style="
                        font-size:19px;
                        font-weight:bold;
                        margin-bottom:8px;
                    ">
                        Rp {{ number_format($order->total,0,',','.') }}
                    </div>

                    <span style="
                        display:inline-block;
                        background:{{ $statusColors[$status] ?? '#f1f5f9' }};
                        color:{{ $statusTextColors[$status] ?? '#334155' }};
                        padding:7px 13px;
                        border-radius:20px;
                        font-weight:bold;
                    ">
                        {{ $statusLabels[$status] ?? ucfirst($status) }}
                    </span>

                </div>

            </div>

            {{-- PAYMENT --}}
            <div style="
                background:#f8fafc;
                padding:14px 16px;
                border-radius:12px;
                margin-bottom:18px;
            ">

                💳
                <strong>Pembayaran:</strong>
                {{ strtoupper($order->payment_method ?? '-') }}

            </div>

            {{-- TRACKING --}}
            <details style="
                background:#fafafa;
                border-radius:12px;
                padding:15px;
                margin-bottom:20px;
            ">

                <summary style="
                    cursor:pointer;
                    font-weight:bold;
                    font-size:17px;
                ">
                    🔎 Lacak Pesanan
                </summary>

                <div style="
                    margin-top:25px;
                    display:flex;
                    justify-content:space-between;
                    gap:8px;
                    flex-wrap:wrap;
                ">

                    @foreach($timeline as $index => $step)

                        @php
                            $done = $index <= $statusIndex;
                        @endphp

                        <div style="
                            flex:1;
                            min-width:120px;
                            text-align:center;
                        ">

                            <div style="
                                width:40px;
                                height:40px;
                                line-height:40px;
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
                                {{ $statusLabels[$step] }}
                            </div>

                        </div>

                    @endforeach

                </div>

            </details>

            {{-- ITEMS --}}
            <div>

                <h3 style="margin-bottom:12px;">
                    📚 Buku yang Dibeli
                </h3>

                @forelse($order->items as $item)

                    <div style="
                        display:flex;
                        align-items:center;
                        gap:15px;
                        padding:15px 0;
                        border-bottom:1px solid #eee;
                    ">

                        @if(!empty($item->book_image))

                            <img
                                src="{{ asset('img/' . $item->book_image) }}"
                                style="
                                    width:70px;
                                    height:90px;
                                    object-fit:cover;
                                    border-radius:8px;
                                "
                                onerror="this.style.display='none';"
                            >

                        @else

                            <div style="
                                width:70px;
                                height:90px;
                                background:#f1f5f9;
                                border-radius:8px;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                font-size:28px;
                            ">
                                📕
                            </div>

                        @endif

                        <div style="flex:1;">

                            <div style="
                                font-weight:bold;
                                font-size:16px;
                                margin-bottom:5px;
                            ">
                                {{ $item->book_title ?? 'Buku' }}
                            </div>

                            <div style="color:#666;">
                                Jumlah: {{ $item->qty }}
                            </div>

                            <div style="color:#666;">
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

                    {{-- RATING --}}
                    @if($status === 'completed')

                        <div style="
                            background:#f8fafc;
                            padding:18px;
                            border-radius:12px;
                            margin:15px 0 5px;
                        ">

                            @if($item->review)

                                <div style="
                                    font-weight:bold;
                                    margin-bottom:8px;
                                ">
                                    ⭐ Penilaian Kamu
                                </div>

                                <div style="
                                    font-size:22px;
                                    margin-bottom:8px;
                                ">
                                    @for($i = 1; $i <= 5; $i++)

                                        @if($i <= $item->review->rating)
                                            ⭐
                                        @else
                                            ☆
                                        @endif

                                    @endfor
                                </div>

                                @if(!empty($item->review->comment))

                                    <div style="
                                        color:#555;
                                        font-style:italic;
                                    ">
                                        "{{ $item->review->comment }}"
                                    </div>

                                @endif

                            @else

                                <div style="
                                    font-weight:bold;
                                    margin-bottom:12px;
                                ">
                                    ⭐ Beri Penilaian Buku Ini
                                </div>

                                <form
                                    method="POST"
                                    action="{{ url('/reviews') }}"
                                >

                                    @csrf

                                    <input
                                        type="hidden"
                                        name="order_id"
                                        value="{{ $order->id }}"
                                    >

                                    <input
                                        type="hidden"
                                        name="book_id"
                                        value="{{ $item->book_id }}"
                                    >

                                    <div style="
                                        display:flex;
                                        gap:8px;
                                        flex-wrap:wrap;
                                        margin-bottom:12px;
                                    ">

                                        @for($i = 1; $i <= 5; $i++)

                                            <label style="
                                                cursor:pointer;
                                                font-size:25px;
                                            ">

                                                <input
                                                    type="radio"
                                                    name="rating"
                                                    value="{{ $i }}"
                                                    required
                                                >

                                                {{ $i }}⭐

                                            </label>

                                        @endfor

                                    </div>

                                    <textarea
                                        name="comment"
                                        placeholder="Tulis komentar tentang buku ini..."
                                        style="
                                            width:100%;
                                            min-height:80px;
                                            padding:12px;
                                            border:1px solid #ddd;
                                            border-radius:10px;
                                            resize:vertical;
                                            box-sizing:border-box;
                                            margin-bottom:10px;
                                        "
                                    ></textarea>

                                    <button
                                        type="submit"
                                        style="
                                            border:none;
                                            background:#111827;
                                            color:white;
                                            padding:10px 18px;
                                            border-radius:10px;
                                            font-weight:bold;
                                            cursor:pointer;
                                        "
                                    >
                                        ⭐ Kirim Penilaian
                                    </button>

                                </form>

                            @endif

                        </div>

                    @endif

                @empty

                    <div style="
                        padding:20px;
                        text-align:center;
                        color:#777;
                    ">
                        Tidak ada buku dalam pesanan ini.
                    </div>

                @endforelse

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

            <div style="
                font-size:55px;
                margin-bottom:15px;
            ">
                📦
            </div>

            <h2>Belum ada pesanan</h2>

            <p style="color:#777;">
                Pesanan kamu akan muncul di sini.
            </p>

        </div>

    @endforelse

</div>

@endsection