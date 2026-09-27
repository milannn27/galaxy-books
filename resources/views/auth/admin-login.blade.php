@extends('layouts.app')

@section('content')

<style>
    .admin-page {
        width: 92%;
        max-width: 1200px;
        margin: 35px auto;
    }

    /* HEADER */
    .admin-header {
        background: linear-gradient(135deg, #075985, #2563eb, #16a34a);
        color: white;
        padding: 35px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,.15);
        margin-bottom: 25px;
    }

    .admin-header h1 {
        margin: 0 0 8px;
        font-size: 32px;
    }

    .admin-header p {
        margin: 0;
        opacity: .95;
    }

    /* STAT */
    .stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: white;
        padding: 22px;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0,0,0,.07);
        border-left: 5px solid #2563eb;
    }

    .stat-card.green {
        border-left-color: #16a34a;
    }

    .stat-card.yellow {
        border-left-color: #f59e0b;
    }

    .stat-icon {
        font-size: 28px;
        margin-bottom: 8px;
    }

    .stat-title {
        color: #64748b;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .stat-number {
        font-size: 25px;
        font-weight: bold;
        color: #111827;
    }

    /* ACTION */
    .admin-actions {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .action-btn {
        display: inline-block;
        padding: 12px 18px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: bold;
        color: white;
    }

    .add-btn {
        background: #16a34a;
    }

    .add-btn:hover {
        background: #15803d;
    }

    .home-btn {
        background: #111827;
    }

    .home-btn:hover {
        background: #374151;
    }

    /* TABLE */
    .table-container {
        background: white;
        border-radius: 16px;
        overflow-x: auto;
        box-shadow: 0 7px 25px rgba(0,0,0,.08);
    }

    .table-header {
        padding: 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .table-header h2 {
        margin: 0 0 5px;
        color: #111827;
    }

    .table-header p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 850px;
    }

    th {
        background: #075985;
        color: white;
        padding: 14px;
        text-align: left;
        font-size: 14px;
    }

    td {
        padding: 14px;
        border-bottom: 1px solid #e5e7eb;
        color: #374151;
    }

    tr:hover td {
        background: #f8fafc;
    }

    /* BOOK IMAGE */
    .book-thumb {
        width: 55px;
        height: 70px;
        object-fit: cover;
        border-radius: 7px;
        background: #e5e7eb;
    }

    .no-image {
        width: 55px;
        height: 70px;
        background: #e5e7eb;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
    }

    /* STOCK */
    .stock {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        background: #dcfce7;
        color: #166534;
        font-weight: bold;
        font-size: 12px;
    }

    .stock-low {
        background: #fef3c7;
        color: #92400e;
    }

    .stock-empty {
        background: #fee2e2;
        color: #991b1b;
    }

    /* ACTION TABLE */
    .edit-btn {
        display: inline-block;
        background: #f59e0b;
        color: white;
        text-decoration: none;
        padding: 8px 11px;
        border-radius: 7px;
        font-size: 12px;
        font-weight: bold;
        margin-right: 4px;
    }

    .edit-btn:hover {
        background: #d97706;
    }

    .delete-btn {
        background: #dc2626;
        color: white;
        border: none;
        padding: 8px 11px;
        border-radius: 7px;
        font-size: 12px;
        font-weight: bold;
        cursor: pointer;
    }

    .delete-btn:hover {
        background: #b91c1c;
    }

    /* EMPTY */
    .empty {
        text-align: center;
        padding: 50px 20px;
        color: #64748b;
    }

    .empty-icon {
        font-size: 55px;
        margin-bottom: 10px;
    }

    @media (max-width: 800px) {

        .stats {
            grid-template-columns: 1fr;
        }

        .admin-header h1 {
            font-size: 25px;
        }

        .admin-page {
            width: 94%;
        }
    }
</style>


@php

    /*
    |--------------------------------------------------------------------------
    | DATA BUKU
    |--------------------------------------------------------------------------
    */

    $books = \App\Models\Book::all();

    $totalBooks = $books->count();

    $totalStock = $books->sum('stock');

    $outOfStock = $books->where('stock', '<=', 0)->count();

@endphp


<div class="admin-page">

    {{-- ======================================== --}}
    {{-- HEADER --}}
    {{-- ======================================== --}}

    <div class="admin-header">

        <h1>
            👑 Admin Dashboard
        </h1>

        <p>
            Selamat datang, Admin.
            Kelola seluruh koleksi buku Galaxy Books di sini.
        </p>

    </div>


    {{-- ======================================== --}}
    {{-- STATISTIK --}}
    {{-- ======================================== --}}

    <div class="stats">

        {{-- TOTAL BUKU --}}
        <div class="stat-card">

            <div class="stat-icon">
                📚
            </div>

            <div class="stat-title">
                Total Judul Buku
            </div>

            <div class="stat-number">
                {{ $totalBooks }}
            </div>

        </div>


        {{-- TOTAL STOK --}}
        <div class="stat-card green">

            <div class="stat-icon">
                📦
            </div>

            <div class="stat-title">
                Total Stok
            </div>

            <div class="stat-number">
                {{ $totalStock }}
            </div>

        </div>


        {{-- BUKU HABIS --}}
        <div class="stat-card yellow">

            <div class="stat-icon">
                ⚠️
            </div>

            <div class="stat-title">
                Buku Stok Habis
            </div>

            <div class="stat-number">
                {{ $outOfStock }}
            </div>

        </div>

    </div>


    {{-- ======================================== --}}
    {{-- TOMBOL ADMIN --}}
    {{-- ======================================== --}}

    <div class="admin-actions">

        <a
            href="/admin/books/create"
            class="action-btn add-btn"
        >
            ➕ Tambah Buku
        </a>


        <a
            href="/"
            class="action-btn home-btn"
        >
            🏠 Lihat Website
        </a>

    </div>


    {{-- ======================================== --}}
    {{-- TABEL BUKU --}}
    {{-- ======================================== --}}

    <div class="table-container">

        <div class="table-header">

            <h2>
                📚 Kelola Koleksi Buku
            </h2>

            <p>
                Admin dapat menambah, mengedit, dan menghapus buku.
            </p>

        </div>


        @if($books->count() > 0)

            <table>

                <thead>

                    <tr>

                        <th>
                            No
                        </th>

                        <th>
                            Buku
                        </th>

                        <th>
                            Judul
                        </th>

                        <th>
                            Penulis
                        </th>

                        <th>
                            Harga
                        </th>

                        <th>
                            Stok
                        </th>

                        <th>
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($books as $book)

                        <tr>

                            {{-- NO --}}
                            <td>
                                {{ $loop->iteration }}
                            </td>


                            {{-- GAMBAR --}}
                            <td>

                                @php

                                    $image = null;

                                    if (
                                        !empty($book->image) &&
                                        file_exists(
                                            public_path(
                                                'img/' . $book->image
                                            )
                                        )
                                    ) {

                                        $image = asset(
                                            'img/' . $book->image
                                        );

                                    }

                                    elseif (
                                        strtolower($book->title)
                                        == 'laskar pelangi'
                                    ) {

                                        $files = glob(
                                            public_path(
                                                'img/026174800*'
                                            )
                                        );

                                        if (!empty($files)) {

                                            $image = asset(
                                                'img/' .
                                                basename($files[0])
                                            );

                                        }

                                    }

                                    elseif (
                                        strtolower($book->title)
                                        == 'bumi'
                                    ) {

                                        $files = glob(
                                            public_path(
                                                'img/img20220905*'
                                            )
                                        );

                                        if (!empty($files)) {

                                            $image = asset(
                                                'img/' .
                                                basename($files[0])
                                            );

                                        }

                                    }

                                    elseif (
                                        strtolower($book->title)
                                        == 'filosofi teras'
                                    ) {

                                        $files = glob(
                                            public_path(
                                                'img/gQpkhLmp*'
                                            )
                                        );

                                        if (!empty($files)) {

                                            $image = asset(
                                                'img/' .
                                                basename($files[0])
                                            );

                                        }

                                    }

                                @endphp


                                @if($image)

                                    <img
                                        src="{{ $image }}"
                                        alt="{{ $book->title }}"
                                        class="book-thumb"
                                    >

                                @else

                                    <div class="no-image">
                                        📖
                                    </div>

                                @endif

                            </td>


                            {{-- JUDUL --}}
                            <td>

                                <strong>
                                    {{ $book->title }}
                                </strong>

                            </td>


                            {{-- PENULIS --}}
                            <td>
                                {{ $book->author }}
                            </td>


                            {{-- HARGA --}}
                            <td>

                                Rp
                                {{ number_format(
                                    $book->price,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </td>


                            {{-- STOK --}}
                            <td>

                                @if($book->stock <= 0)

                                    <span class="stock stock-empty">
                                        Habis
                                    </span>

                                @elseif($book->stock <= 5)

                                    <span class="stock stock-low">
                                        {{ $book->stock }}
                                    </span>

                                @else

                                    <span class="stock">
                                        {{ $book->stock }}
                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}
                            <td>

                                {{-- EDIT --}}
                                <a
                                    href="/admin/books/{{ $book->id }}/edit"
                                    class="edit-btn"
                                >
                                    ✏️ Edit
                                </a>


                                {{-- HAPUS --}}
                                <form
                                    action="/admin/books/{{ $book->id }}"
                                    method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm(
                                        'Yakin ingin menghapus buku {{ $book->title }}?'
                                    )"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="delete-btn"
                                    >
                                        🗑️ Hapus
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <div class="empty">

                <div class="empty-icon">
                    📚
                </div>

                <h3>
                    Belum ada buku
                </h3>

                <p>
                    Silakan tambahkan buku pertama melalui tombol
                    <strong>Tambah Buku</strong>.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection