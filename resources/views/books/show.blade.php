@extends('layouts.app')

@section('content')

@php
    use Illuminate\Support\Facades\DB;

    /*
    |--------------------------------------------------------------------------
    | AMBIL ULASAN BUKU
    |--------------------------------------------------------------------------
    */

    $reviews = DB::table('reviews')
        ->leftJoin('users', 'reviews.user_id', '=', 'users.id')
        ->where('reviews.book_id', $book->id)
        ->select(
            'reviews.*',
            'users.name as user_name'
        )
        ->orderBy('reviews.created_at', 'desc')
        ->get();

    $reviewCount = $reviews->count();

    $averageRating = $reviewCount > 0
        ? round($reviews->avg('rating'), 1)
        : 0;
@endphp


<style>

    * {
        box-sizing: border-box;
    }

    .detail-wrapper {
        max-width: 1100px;
        margin: 35px auto;
        padding: 20px;
    }

    /* =====================================================
       TOMBOL KEMBALI
    ===================================================== */

    .back-btn {
        display: inline-block;
        margin-bottom: 20px;
        padding: 10px 16px;
        background: #f1f5f9;
        color: #111827;
        text-decoration: none;
        border-radius: 10px;
        font-weight: bold;
    }

    .back-btn:hover {
        background: #e2e8f0;
    }


    /* =====================================================
       DETAIL BUKU
    ===================================================== */

    .book-detail {
        display: grid;
        grid-template-columns: 360px 1fr;
        gap: 35px;
        background: white;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 7px 25px rgba(0,0,0,.08);
        margin-bottom: 30px;
    }


    /* =====================================================
       GAMBAR BUKU
    ===================================================== */

    .book-image-wrapper {
        width: 100%;
        height: 470px;
        background: #f1f5f9;
        border-radius: 15px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .book-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .no-image {
        font-size: 80px;
    }


    /* =====================================================
       INFO BUKU
    ===================================================== */

    .book-info h1 {
        margin: 0 0 10px;
        font-size: 32px;
        color: #111827;
    }

    .author {
        color: #64748b;
        font-size: 16px;
        margin-bottom: 20px;
    }

    .category {
        display: inline-block;
        background: #dbeafe;
        color: #1d4ed8;
        padding: 7px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .price {
        font-size: 30px;
        font-weight: bold;
        color: #2563eb;
        margin: 15px 0;
    }

    .stock {
        display: inline-block;
        background: #dcfce7;
        color: #166534;
        padding: 8px 13px;
        border-radius: 20px;
        font-weight: bold;
        margin-bottom: 25px;
    }

    .stock-empty {
        background: #fee2e2;
        color: #991b1b;
    }


    /* =====================================================
       TOMBOL CART
    ===================================================== */

    .cart-btn {
        display: inline-block;
        padding: 13px 22px;
        background: #facc15;
        color: #111827;
        text-decoration: none;
        border-radius: 10px;
        font-weight: bold;
        border: none;
    }

    .cart-btn:hover {
        background: #eab308;
    }


    /* =====================================================
       BAGIAN ULASAN
    ===================================================== */

    .review-section {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 7px 25px rgba(0,0,0,.08);
    }

    .review-title {
        margin-top: 0;
        margin-bottom: 25px;
        font-size: 25px;
        color: #111827;
    }


    /* =====================================================
       RATING SUMMARY
    ===================================================== */

    .rating-summary {
        display: flex;
        align-items: center;
        gap: 30px;
        padding: 25px;
        background: #f8fafc;
        border-radius: 15px;
        margin-bottom: 25px;
    }

    .rating-number {
        font-size: 52px;
        font-weight: bold;
        color: #111827;
        line-height: 1;
    }

    .rating-stars {
        color: #fbbf24;
        font-size: 25px;
        letter-spacing: 2px;
    }

    .rating-count {
        color: #64748b;
        margin-top: 6px;
    }


    /* =====================================================
       REVIEW CARD
    ===================================================== */

    .review-card {
        border-bottom: 1px solid #e5e7eb;
        padding: 20px 0;
    }

    .review-card:last-child {
        border-bottom: none;
    }

    .review-user {
        font-weight: bold;
        color: #111827;
        font-size: 16px;
    }

    .review-date {
        color: #94a3b8;
        font-size: 12px;
        margin-top: 4px;
    }

    .review-comment {
        margin-top: 12px;
        color: #374151;
        line-height: 1.6;
        background: #f8fafc;
        padding: 12px 15px;
        border-radius: 10px;
    }


    /* =====================================================
       BELUM ADA ULASAN
    ===================================================== */

    .empty-review {
        text-align: center;
        padding: 45px 20px;
        color: #64748b;
    }

    .empty-review-icon {
        font-size: 50px;
        margin-bottom: 10px;
    }


    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 800px) {

        .book-detail {
            grid-template-columns: 1fr;
        }

        .book-image-wrapper {
            height: 400px;
        }

        .rating-summary {
            flex-direction: column;
            align-items: flex-start;
        }

    }

</style>


<div class="detail-wrapper">

    {{-- =====================================================
         KEMBALI
    ====================================================== --}}

    <a href="/" class="back-btn">
        ← Kembali ke Koleksi
    </a>


    {{-- =====================================================
         DETAIL BUKU
    ====================================================== --}}

    <div class="book-detail">

        {{-- GAMBAR BUKU --}}

        <div class="book-image-wrapper">

            @if(
                !empty($book->image)
                &&
                file_exists(
                    public_path('img/' . $book->image)
                )
            )

                <img
                    src="{{ asset('img/' . $book->image) }}"
                    alt="{{ $book->title }}"
                    class="book-image"
                >

            @else

                <div class="no-image">
                    📕
                </div>

            @endif

        </div>


        {{-- INFORMASI BUKU --}}

        <div class="book-info">

            <h1>
                {{ $book->title }}
            </h1>


            <div class="author">
                ✍️ {{ $book->author }}
            </div>


            {{-- KATEGORI --}}

            @if(!empty($book->category))

                <span class="category">
                    📚 {{ $book->category }}
                </span>

            @endif


            {{-- HARGA --}}

            <div class="price">
                Rp {{ number_format($book->price, 0, ',', '.') }}
            </div>


            {{-- STOK --}}

            @if($book->stock > 0)

                <span class="stock">
                    📦 Stok tersedia: {{ $book->stock }}
                </span>

            @else

                <span class="stock stock-empty">
                    ❌ Stok habis
                </span>

            @endif


            {{-- TOMBOL KERANJANG --}}

            <div style="margin-top:20px;">

                @if($book->stock > 0)

                    @auth

                        @if(!auth()->user()->is_admin)

                            <a
                                href="{{ url('/cart/add/' . $book->id) }}"
                                class="cart-btn"
                            >
                                🛒 Tambah ke Keranjang
                            </a>

                        @endif

                    @else

                        <a
                            href="/login"
                            class="cart-btn"
                        >
                            🛒 Login untuk Membeli
                        </a>

                    @endauth

                @endif

            </div>

        </div>

    </div>



    {{-- =====================================================
         ULASAN PEMBELI
    ====================================================== --}}

    <div class="review-section">

        <h2 class="review-title">
            ⭐ Ulasan Pembeli
        </h2>


        {{-- =================================================
             RATING SUMMARY
        ================================================== --}}

        <div class="rating-summary">

            <div>

                <div class="rating-number">
                    {{ number_format($averageRating, 1) }}
                </div>


                <div class="rating-stars">

                    @for($i = 1; $i <= 5; $i++)

                        @if($averageRating >= $i)

                            ★

                        @else

                            ☆

                        @endif

                    @endfor

                </div>

            </div>


            <div>

                <div style="
                    font-size:18px;
                    font-weight:bold;
                    color:#111827;
                ">

                    {{ $reviewCount }} Ulasan

                </div>


                <div class="rating-count">

                    Rating dari pembeli yang sudah
                    menyelesaikan pesanan.

                </div>

            </div>

        </div>



        {{-- =================================================
             DAFTAR ULASAN
        ================================================== --}}

        @if($reviews->count() > 0)

            @foreach($reviews as $review)

                <div class="review-card">

                    <div style="
                        display:flex;
                        justify-content:space-between;
                        align-items:flex-start;
                        gap:15px;
                        flex-wrap:wrap;
                    ">

                        {{-- USER --}}

                        <div>

                            @php
                                $namaPembeli =
                                    $review->user_name
                                    ?? 'Pembeli';
                            @endphp


                            <div class="review-user">

                                👤 {{ $namaPembeli }}

                            </div>


                            <div class="review-date">

                                {{ \Carbon\Carbon::parse($review->created_at)->format('d M Y') }}

                            </div>

                        </div>


                        {{-- BINTANG --}}

                        <div class="rating-stars">

                            @for($i = 1; $i <= 5; $i++)

                                @if($i <= $review->rating)

                                    ★

                                @else

                                    ☆

                                @endif

                            @endfor

                        </div>

                    </div>


                    {{-- KOMENTAR --}}

                    @if(!empty($review->comment))

                        <div class="review-comment">

                            "{{ $review->comment }}"

                        </div>

                    @else

                        <div class="review-comment">

                            Pembeli memberikan rating
                            tanpa komentar.

                        </div>

                    @endif

                </div>

            @endforeach


        @else


            {{-- =================================================
                 BELUM ADA ULASAN
            ================================================== --}}

            <div class="empty-review">

                <div class="empty-review-icon">
                    💬
                </div>


                <h3 style="color:#111827;">
                    Belum ada ulasan
                </h3>


                <p>
                    Jadilah pembeli pertama yang memberikan
                    ulasan untuk buku ini.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection