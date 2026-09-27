@extends('layouts.app')

@section('content')

<style>
    * {
        box-sizing: border-box;
    }

    body {
        background: #f5f7fb;
    }

    .home-container {
        width: 92%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 25px 0 50px;
    }

    /* =========================
       HERO
    ========================= */

    .hero {
        min-height: 330px;
        border-radius: 25px;
        padding: 45px 50px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;

        background:
            radial-gradient(circle at 85% 20%, rgba(255,255,255,.20), transparent 25%),
            radial-gradient(circle at 70% 90%, rgba(255,255,255,.12), transparent 30%),
            linear-gradient(135deg, #0f172a, #1d4ed8 55%, #2563eb);

        color: white;
        box-shadow: 0 15px 35px rgba(15,23,42,.20);

        display: flex;
        align-items: center;
    }

    .hero::before {
        content: "✦";
        position: absolute;
        right: 150px;
        top: 45px;
        font-size: 30px;
        opacity: .5;
    }

    .hero::after {
        content: "✦";
        position: absolute;
        right: 70px;
        bottom: 45px;
        font-size: 22px;
        opacity: .4;
    }

    .hero-content {
        max-width: 650px;
        position: relative;
        z-index: 2;
    }

    .hero-badge {
        display: inline-block;
        background: rgba(255,255,255,.15);
        border: 1px solid rgba(255,255,255,.25);
        padding: 7px 14px;
        border-radius: 30px;
        font-size: 13px;
        margin-bottom: 15px;
        backdrop-filter: blur(5px);
    }

    .hero h1 {
        margin: 0 0 12px;
        font-size: 42px;
        line-height: 1.15;
        letter-spacing: -.8px;
    }

    .hero h1 span {
        color: #bfdbfe;
    }

    .hero p {
        margin: 0 0 25px;
        color: #e0e7ff;
        font-size: 16px;
        line-height: 1.7;
    }

    .hero-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: white;
        color: #1d4ed8;
        padding: 12px 20px;
        border-radius: 11px;
        text-decoration: none;
        font-weight: bold;
        transition: .2s;
    }

    .hero-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,.18);
    }

    .hero-book {
        position: absolute;
        right: 55px;
        bottom: -25px;
        font-size: 180px;
        opacity: .14;
        transform: rotate(-8deg);
    }

    /* =========================
       SECTION
    ========================= */

    .section {
        margin-bottom: 32px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .section-title {
        margin: 0;
        color: #111827;
        font-size: 23px;
        font-weight: 800;
    }

    .section-subtitle {
        margin: 4px 0 0;
        color: #64748b;
        font-size: 13px;
    }

    /* =========================
       CATEGORY
    ========================= */

    .category-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
    }

    .category-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 15px;
        padding: 20px;
        text-decoration: none;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: .2s;
        box-shadow: 0 4px 15px rgba(15,23,42,.05);
    }

    .category-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(15,23,42,.10);
        border-color: #bfdbfe;
    }

    .category-icon {
        width: 48px;
        height: 48px;
        border-radius: 13px;
        background: #eff6ff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
        flex-shrink: 0;
    }

    .category-card h3 {
        margin: 0 0 4px;
        font-size: 15px;
    }

    .category-card p {
        margin: 0;
        color: #64748b;
        font-size: 12px;
    }

    /* =========================
       PROMO
    ========================= */

    .promo {
        border-radius: 20px;
        padding: 25px 30px;
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        border: 1px solid #bfdbfe;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .promo h2 {
        margin: 0 0 7px;
        color: #1e3a8a;
        font-size: 22px;
    }

    .promo p {
        margin: 0;
        color: #475569;
        font-size: 14px;
    }

    .promo-icon {
        font-size: 55px;
    }

    /* =========================
       SEARCH
    ========================= */

    .search-wrapper {
        position: relative;
        margin-bottom: 22px;
    }

    .search-icon {
        position: absolute;
        left: 17px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 17px;
        color: #64748b;
    }

    .search-box {
        width: 100%;
        padding: 15px 18px 15px 48px;
        border: 1px solid #dbe3ef;
        border-radius: 13px;
        background: white;
        font-size: 14px;
        outline: none;
        box-shadow: 0 5px 18px rgba(15,23,42,.05);
        transition: .2s;
    }

    .search-box:focus {
        border-color: #3b82f6;
        box-shadow: 0 5px 20px rgba(37,99,235,.12);
    }

    /* =========================
       BOOK GRID
    ========================= */

    .book-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    .book-card {
        background: white;
        border-radius: 17px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        box-shadow: 0 5px 18px rgba(15,23,42,.06);
        transition: .25s;
        position: relative;
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(15,23,42,.12);
    }

    /* =========================
       BOOK IMAGE
    ========================= */

    .image-wrapper {
        position: relative;
        overflow: hidden;
        background: #eef2f7;
    }

    .book-image {
        width: 100%;
        height: 255px;
        object-fit: cover;
        display: block;
        transition: .3s;
    }

    .book-card:hover .book-image {
        transform: scale(1.035);
    }

    .no-image {
        width: 100%;
        height: 255px;
        background: linear-gradient(135deg, #e0e7ff, #dbeafe);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 65px;
    }

    .book-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: #111827;
        color: white;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .3px;
    }

    .book-badge.sale {
        background: #dc2626;
    }

    /* =========================
       BOOK INFO
    ========================= */

    .book-info {
        padding: 16px;
    }

    .book-info h3 {
        margin: 0 0 6px;
        color: #111827;
        font-size: 16px;
        line-height: 1.4;

        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .author {
        margin: 0 0 11px;
        color: #64748b;
        font-size: 12px;
    }

    .rating {
        color: #f59e0b;
        font-size: 12px;
        margin-bottom: 8px;
    }

    .price {
        color: #1d4ed8;
        font-size: 18px;
        font-weight: 800;
        margin-bottom: 9px;
    }

    .stock {
        display: inline-flex;
        align-items: center;
        background: #dcfce7;
        color: #166534;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        margin-bottom: 13px;
    }

    .stock-empty {
        background: #fee2e2;
        color: #991b1b;
    }

    /* =========================
       ACTION
    ========================= */

    .book-actions {
        display: flex;
        gap: 7px;
    }

    .detail-btn,
    .cart-btn {
        flex: 1;
        padding: 9px 7px;
        border: none;
        border-radius: 9px;
        text-decoration: none;
        text-align: center;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s;
    }

    .detail-btn {
        background: #f1f5f9;
        color: #334155;
    }

    .detail-btn:hover {
        background: #e2e8f0;
    }

    .cart-btn {
        background: #2563eb;
        color: white;
    }

    .cart-btn:hover {
        background: #1d4ed8;
    }

    .cart-disabled {
        background: #cbd5e1 !important;
        color: #64748b !important;
        cursor: not-allowed;
    }

    /* =========================
       EMPTY
    ========================= */

    .empty {
        background: white;
        padding: 55px 25px;
        text-align: center;
        border-radius: 17px;
        color: #64748b;
        border: 1px solid #e5e7eb;
    }

    .empty-icon {
        font-size: 55px;
        margin-bottom: 10px;
    }

    .empty h2 {
        color: #1e293b;
        margin: 0 0 7px;
    }

    .empty p {
        margin: 0;
    }

    /* =========================
       RESPONSIVE
    ========================= */

    @media (max-width: 1000px) {

        .book-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .category-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .hero-book {
            right: 25px;
        }
    }

    @media (max-width: 750px) {

        .home-container {
            width: 94%;
        }

        .hero {
            padding: 35px 28px;
        }

        .hero h1 {
            font-size: 32px;
        }

        .hero-book {
            display: none;
        }

        .book-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 520px) {

        .book-grid {
            grid-template-columns: 1fr;
        }

        .category-grid {
            grid-template-columns: 1fr;
        }

        .hero h1 {
            font-size: 28px;
        }

        .hero p {
            font-size: 14px;
        }

        .promo {
            padding: 20px;
        }

        .promo-icon {
            font-size: 40px;
        }

        .book-actions {
            flex-direction: column;
        }
    }
</style>


<div class="home-container">


    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="hero">

        <div class="hero-content">

            <div class="hero-badge">
                ✨ Selamat datang di Galaxy Books
            </div>

            <h1>
                Temukan Buku<br>
                <span>Favoritmu.</span>
            </h1>

            <p>
                Jelajahi koleksi buku pilihan untuk belajar,
                membaca, dan berkembang bersama Galaxy Books.
            </p>

            <a href="#koleksi" class="hero-button">
                🛍️ Mulai Belanja
            </a>

        </div>

        <div class="hero-book">
            📚
        </div>

    </section>


    {{-- =====================================================
         KATEGORI
    ====================================================== --}}

    <section class="section">

        <div class="section-header">

            <div>

                <h2 class="section-title">
                    📂 Jelajahi Kategori
                </h2>

                <p class="section-subtitle">
                    Temukan buku berdasarkan minatmu
                </p>

            </div>

        </div>


        <div class="category-grid">


            {{-- NOVEL --}}

            <a href="{{ url('/category/Novel') }}" class="category-card">

                <div class="category-icon">
                    📖
                </div>

                <div>
                    <h3>Novel</h3>
                    <p>Cerita & sastra</p>
                </div>

            </a>


            {{-- PENDIDIKAN --}}

            <a href="{{ url('/category/Pendidikan') }}" class="category-card">

                <div class="category-icon">
                    🎓
                </div>

                <div>
                    <h3>Pendidikan</h3>
                    <p>Belajar lebih mudah</p>
                </div>

            </a>


            {{-- SELF IMPROVEMENT --}}

            <a href="{{ url('/category/Self%20Improvement') }}" class="category-card">

                <div class="category-icon">
                    💡
                </div>

                <div>
                    <h3>Self Improvement</h3>
                    <p>Kembangkan diri</p>
                </div>

            </a>


            {{-- SAINS --}}

            <a href="{{ url('/category/Sains') }}" class="category-card">

                <div class="category-icon">
                    🔬
                </div>

                <div>
                    <h3>Sains</h3>
                    <p>Pengetahuan baru</p>
                </div>

            </a>


            {{-- LAINNYA --}}

            <a href="{{ url('/category/Lainnya') }}" class="category-card">

                <div class="category-icon">
                    📚
                </div>

                <div>
                    <h3>Lainnya</h3>
                    <p>Koleksi lainnya</p>
                </div>

            </a>


        </div>

    </section>


    {{-- =====================================================
         PROMO
    ====================================================== --}}

    <section class="section">

        <div class="promo">

            <div>

                <h2>
                    🔥 Temukan Buku Pilihanmu
                </h2>

                <p>
                    Koleksi buku terbaik tersedia di Galaxy Books.
                    Jangan sampai kehabisan!
                </p>

            </div>

            <div class="promo-icon">
                📚
            </div>

        </div>

    </section>


    {{-- =====================================================
         KOLEKSI BUKU
    ====================================================== --}}

    <section class="section" id="koleksi">

        <div class="section-header">

            <div>

                <h2 class="section-title">
                    📚 Koleksi Buku
                </h2>

                <p class="section-subtitle">
                    Pilih buku favoritmu dan masukkan ke keranjang
                </p>

            </div>

        </div>


        {{-- SEARCH --}}

        <div class="search-wrapper">

            <span class="search-icon">
                🔍
            </span>

            <input
                type="text"
                id="searchBook"
                class="search-box"
                placeholder="Cari judul atau penulis buku..."
            >

        </div>


        @if($books->count() > 0)

            <div
                class="book-grid"
                id="bookGrid"
            >


                @foreach($books as $book)

                    <div
                        class="book-card"
                        data-title="{{ strtolower($book->title) }}"
                        data-author="{{ strtolower($book->author) }}"
                    >


                        {{-- =========================
                             GAMBAR
                        ========================== --}}

                        @php

                            $image = null;


                            /*
                            | Gambar dari database
                            */

                            if (
                                !empty($book->image) &&
                                file_exists(
                                    public_path('img/' . $book->image)
                                )
                            ) {

                                $image = asset(
                                    'img/' . $book->image
                                );

                            }


                            /*
                            | Gambar buku lama
                            */

                            elseif (
                                strtolower($book->title) == 'laskar pelangi'
                            ) {

                                $files = glob(
                                    public_path('img/026174800*')
                                );

                                if (!empty($files)) {

                                    $image = asset(
                                        'img/' . basename($files[0])
                                    );

                                }

                            }


                            elseif (
                                strtolower($book->title) == 'bumi'
                            ) {

                                $files = glob(
                                    public_path('img/img20220905*')
                                );

                                if (!empty($files)) {

                                    $image = asset(
                                        'img/' . basename($files[0])
                                    );

                                }

                            }


                            elseif (
                                strtolower($book->title) == 'filosofi teras'
                            ) {

                                $files = glob(
                                    public_path('img/gQpkhLmp*')
                                );

                                if (!empty($files)) {

                                    $image = asset(
                                        'img/' . basename($files[0])
                                    );

                                }

                            }

                        @endphp


                        {{-- =========================
                             IMAGE
                        ========================== --}}

                        <div class="image-wrapper">

                            @if($image)

                                <img
                                    src="{{ $image }}"
                                    alt="{{ $book->title }}"
                                    class="book-image"
                                >

                            @else

                                <div class="no-image">
                                    📖
                                </div>

                            @endif


                            {{-- BADGE --}}

                            @if($book->stock > 0)

                                <div class="book-badge">
                                    TERSEDIA
                                </div>

                            @else

                                <div class="book-badge sale">
                                    HABIS
                                </div>

                            @endif

                        </div>


                        {{-- =========================
                             INFO
                        ========================== --}}

                        <div class="book-info">

                            <h3>
                                {{ $book->title }}
                            </h3>

                            <p class="author">
                                ✍️ {{ $book->author }}
                            </p>


                            <div class="rating">
                                ⭐⭐⭐⭐⭐
                                <span style="color:#94a3b8;">
                                    Buku pilihan
                                </span>
                            </div>


                            <div class="price">
                                Rp {{ number_format($book->price, 0, ',', '.') }}
                            </div>


                            {{-- STOCK --}}

                            @if($book->stock > 0)

                                <span class="stock">
                                    📦 Stok {{ $book->stock }}
                                </span>

                            @else

                                <span class="stock stock-empty">
                                    ❌ Stok Habis
                                </span>

                            @endif


                            {{-- =========================
                                 ACTION
                            ========================== --}}

                            <div class="book-actions">


                                {{-- DETAIL --}}

                                <a
                                    href="/books/{{ $book->id }}"
                                    class="detail-btn"
                                >
                                    👁 Detail
                                </a>


                                {{-- USER --}}

                                @guest

                                    <a
                                        href="/login"
                                        class="cart-btn"
                                    >
                                        🛒 Tambah
                                    </a>

                                @else

                                    @if(!auth()->user()->is_admin)

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
                                                    🛒 Tambah
                                                </button>

                                            </form>

                                        @else

                                            <button
                                                type="button"
                                                class="cart-btn cart-disabled"
                                                style="width:100%;"
                                                disabled
                                            >
                                                ❌ Habis
                                            </button>

                                        @endif

                                    @endif

                                @endauth


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
                    Koleksi buku belum tersedia.
                </p>

            </div>


        @endif

    </section>


</div>


{{-- =====================================================
     SEARCH JAVASCRIPT
====================================================== --}}

<script>

    const searchInput =
        document.getElementById('searchBook');


    if (searchInput) {

        searchInput.addEventListener(
            'input',
            function () {

                const keyword =
                    this.value.toLowerCase().trim();


                const books =
                    document.querySelectorAll('.book-card');


                books.forEach(function (book) {

                    const title =
                        book.dataset.title || '';

                    const author =
                        book.dataset.author || '';


                    if (
                        title.includes(keyword) ||
                        author.includes(keyword)
                    ) {

                        book.style.display = '';

                    } else {

                        book.style.display = 'none';

                    }

                });

            }
        );

    }

</script>


@endsection