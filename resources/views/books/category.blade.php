@extends('layouts.app')

@section('content')

<style>
    .category-page {
        max-width: 1200px;
        margin: 35px auto 60px;
        padding: 0 20px;
    }

    .category-header {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white;
        padding: 35px;
        border-radius: 22px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(37, 99, 235, .18);
    }

    .category-header h1 {
        margin: 0 0 8px;
        font-size: 32px;
    }

    .category-header p {
        margin: 0;
        opacity: .9;
    }

    .back-button {
        display: inline-block;
        margin-top: 18px;
        padding: 10px 16px;
        background: white;
        color: #1d4ed8;
        text-decoration: none;
        border-radius: 9px;
        font-weight: bold;
        font-size: 14px;
    }

    .back-button:hover {
        background: #eff6ff;
    }

    .book-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 22px;
    }

    .book-card {
        background: white;
        border-radius: 17px;
        overflow: hidden;
        box-shadow: 0 7px 22px rgba(15, 23, 42, .07);
        border: 1px solid #e5e7eb;
        transition: .2s;
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 30px rgba(15, 23, 42, .12);
    }

    .book-image {
        width: 100%;
        height: 270px;
        object-fit: cover;
        background: #f1f5f9;
        display: block;
    }

    .no-image {
        height: 270px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        color: #94a3b8;
        font-size: 45px;
    }

    .book-info {
        padding: 17px;
    }

    .book-category {
        display: inline-block;
        background: #eff6ff;
        color: #2563eb;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: bold;
        margin-bottom: 9px;
    }

    .book-title {
        font-size: 17px;
        font-weight: bold;
        color: #111827;
        margin-bottom: 5px;
    }

    .book-author {
        color: #64748b;
        font-size: 13px;
        margin-bottom: 12px;
    }

    .book-price {
        color: #16a34a;
        font-size: 17px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .book-stock {
        color: #64748b;
        font-size: 12px;
        margin-bottom: 13px;
    }

    .book-actions {
        display: flex;
        gap: 8px;
    }

    .detail-btn,
    .cart-btn {
        flex: 1;
        padding: 10px 8px;
        border-radius: 9px;
        text-decoration: none;
        text-align: center;
        font-size: 12px;
        font-weight: bold;
        border: none;
        cursor: pointer;
    }

    .detail-btn {
        background: #111827;
        color: white;
    }

    .cart-btn {
        background: #16a34a;
        color: white;
    }

    .detail-btn:hover {
        background: #374151;
    }

    .cart-btn:hover {
        background: #15803d;
    }

    .empty {
        background: white;
        border-radius: 18px;
        padding: 60px 25px;
        text-align: center;
        box-shadow: 0 7px 22px rgba(15, 23, 42, .06);
    }

    .empty-icon {
        font-size: 55px;
        margin-bottom: 15px;
    }

    .empty h2 {
        color: #111827;
        margin-bottom: 8px;
    }

    .empty p {
        color: #64748b;
        margin-bottom: 20px;
    }

    .empty a {
        display: inline-block;
        padding: 11px 18px;
        background: #2563eb;
        color: white;
        text-decoration: none;
        border-radius: 9px;
        font-weight: bold;
    }

    @media (max-width: 1000px) {
        .book-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 750px) {
        .book-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 500px) {
        .category-page {
            padding: 0 12px;
        }

        .category-header {
            padding: 25px;
        }

        .category-header h1 {
            font-size: 25px;
        }

        .book-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="category-page">

    <div class="category-header">

        <h1>
            @if($category === 'Novel')
                📖
            @elseif($category === 'Pendidikan')
                🎓
            @elseif($category === 'Self Improvement')
                💡
            @elseif($category === 'Sains')
                🔬
            @else
                📚
            @endif

            {{ $category }}
        </h1>

        <p>
            Koleksi buku kategori {{ $category }} di Galaxy Books.
        </p>

        <a href="/" class="back-button">
            ← Kembali ke Beranda
        </a>

    </div>


    @if($books->count() > 0)

        <div class="book-grid">

            @foreach($books as $book)

                <div class="book-card">

                    {{-- GAMBAR BUKU --}}
                    @if(!empty($book->image) && file_exists(public_path('img/' . $book->image)))

                        <img
                            src="{{ asset('img/' . $book->image) }}"
                            alt="{{ $book->title }}"
                            class="book-image"
                        >

                    @else

                        <div class="no-image">
                            📚
                        </div>

                    @endif


                    <div class="book-info">

                        {{-- KATEGORI --}}
                        <span class="book-category">
                            {{ $book->category }}
                        </span>


                        {{-- JUDUL --}}
                        <div class="book-title">
                            {{ $book->title }}
                        </div>


                        {{-- PENULIS --}}
                        <div class="book-author">
                            ✍️ {{ $book->author }}
                        </div>


                        {{-- HARGA --}}
                        <div class="book-price">
                            Rp {{ number_format($book->price, 0, ',', '.') }}
                        </div>


                        {{-- STOK --}}
                        <div class="book-stock">
                            📦 Stok: {{ $book->stock }}
                        </div>


                        {{-- TOMBOL --}}
                        <div class="book-actions">

                            <a
                                href="/books/{{ $book->id }}"
                                class="detail-btn"
                            >
                                Detail
                            </a>


                            @if($book->stock > 0)

                                <form
                                    action="/cart/add/{{ $book->id }}"
                                    method="POST"
                                    style="flex:1;"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="cart-btn"
                                        style="width:100%;"
                                    >
                                        🛒 + Keranjang
                                    </button>

                                </form>

                            @else

                                <button
                                    type="button"
                                    class="cart-btn"
                                    style="width:100%; background:#94a3b8; cursor:not-allowed;"
                                    disabled
                                >
                                    Stok Habis
                                </button>

                            @endif

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty">

            <div class="empty-icon">
                📚
            </div>

            <h2>
                Belum Ada Buku
            </h2>

            <p>
                Belum ada buku dalam kategori {{ $category }}.
            </p>

            <a href="/">
                Lihat Semua Buku
            </a>

        </div>

    @endif

</div>

@endsection