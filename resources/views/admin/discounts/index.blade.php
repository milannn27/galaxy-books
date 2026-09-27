@extends('layouts.app')

@section('content')

<div style="
    max-width:1100px;
    margin:30px auto;
    padding:20px;
">

    <div style="
        background:white;
        padding:25px;
        border-radius:16px;
        box-shadow:0 5px 20px rgba(0,0,0,.08);
    ">

        <h1 style="
            margin:0 0 8px;
            color:#1e293b;
        ">
            🏷️ Diskon & Event
        </h1>

        <p style="
            color:#666;
            margin-bottom:20px;
        ">
            Kelola harga diskon buku Galaxy Books.
        </p>

        <hr style="margin:20px 0;">

        @php
            $books = \App\Models\Book::orderBy('id', 'desc')->get();
        @endphp

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
                <strong>❌ Terjadi kesalahan:</strong>

                <ul style="margin:8px 0 0 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @forelse($books as $book)

            <div style="
                display:flex;
                justify-content:space-between;
                align-items:center;
                gap:20px;
                padding:20px 0;
                border-bottom:1px solid #eee;
            ">

                <div style="flex:1;">

                    <h3 style="
                        margin:0 0 8px;
                        color:#1e293b;
                    ">
                        📚 {{ $book->title }}
                    </h3>

                    <p style="
                        margin:4px 0;
                        color:#666;
                    ">
                        {{ $book->author }}
                    </p>

                    <div style="
                        margin-top:10px;
                    ">

                        <span style="
                            color:#64748b;
                            font-size:13px;
                        ">
                            Harga buku
                        </span>

                        <br>

                        <strong style="
                            font-size:18px;
                            color:#2563eb;
                        ">
                            Rp {{ number_format($book->price,0,',','.') }}
                        </strong>

                    </div>

                </div>

                <div style="
                    display:flex;
                    align-items:center;
                    gap:10px;
                ">

                    <a
                        href="{{ url('/books/' . $book->id . '/edit') }}"
                        style="
                            background:#2563eb;
                            color:white;
                            padding:10px 16px;
                            border-radius:8px;
                            text-decoration:none;
                            font-weight:bold;
                            white-space:nowrap;
                        "
                    >
                        ✏️ Edit Harga
                    </a>

                </div>

            </div>

        @empty

            <div style="
                text-align:center;
                padding:40px;
                color:#777;
            ">
                <div style="
                    font-size:45px;
                    margin-bottom:10px;
                ">
                    📚
                </div>

                <strong>
                    Belum ada buku.
                </strong>

                <p>
                    Tambahkan buku terlebih dahulu.
                </p>
            </div>

        @endforelse

    </div>

</div>

@endsection