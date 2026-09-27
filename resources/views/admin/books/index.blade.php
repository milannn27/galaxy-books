@extends('layouts.app')

@section('title', 'Kelola Buku')

@section('content')

<style>
    .admin-page {
        width: 92%;
        max-width: 1250px;
        margin: 35px auto;
    }

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
        min-width: 1100px;
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
        vertical-align: middle;
    }

    tr:hover td {
        background: #f8fafc;
    }

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

    /* =========================
       TOMBOL AKSI BUKU
    ========================= */

    .book-actions {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        align-items: center !important;
        justify-content: flex-start !important;
        gap: 8px !important;

        width: 180px !important;
        min-width: 180px !important;

        white-space: nowrap !important;
    }

    .book-actions form {
        display: inline-block !important;

        width: auto !important;
        min-width: 0 !important;

        margin: 0 !important;
        padding: 0 !important;
    }

    .book-actions a.edit-btn,
    .book-actions button.delete-btn {
        display: inline-flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: center !important;

        width: 82px !important;
        min-width: 82px !important;
        max-width: 82px !important;

        height: 36px !important;
        min-height: 36px !important;

        margin: 0 !important;
        padding: 0 !important;

        border: none !important;
        border-radius: 7px !important;

        font-size: 12px !important;
        font-weight: bold !important;

        text-decoration: none !important;
        white-space: nowrap !important;

        box-sizing: border-box !important;
        cursor: pointer !important;
    }

    .book-actions .edit-btn {
        background: #2563eb !important;
        color: white !important;
    }

    .book-actions .edit-btn:hover {
        background: #1d4ed8 !important;
    }

    .book-actions .delete-btn {
        background: #dc2626 !important;
        color: white !important;
    }

    .book-actions .delete-btn:hover {
        background: #b91c1c !important;
    }

    .category {
        display: inline-block;
        background: #eff6ff;
        color: #1d4ed8;
        padding: 5px 9px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: bold;
    }

    .description {
        max-width: 230px;
        color: #64748b;
        font-size: 13px;
        line-height: 1.5;
    }

    .empty {
        text-align: center;
        padding: 50px 20px;
        color: #64748b;
    }

    .empty-icon {
        font-size: 55px;
        margin-bottom: 10px;
    }

    .success-message {
        background: #dcfce7;
        color: #166534;
        padding: 14px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-weight: 600;
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

    $books = \App\Models\Book::orderBy('id', 'desc')->get();

    $totalBooks = $books->count();

    $totalStock = $books->sum('stock');

    $outOfStock = $books->where('stock', '<=', 0)->count();

@endphp


<div class="admin-page">

    {{-- PESAN SUKSES --}}

    @if(session('success'))

        <div class="success-message">
            ✅ {{ session('success') }}
        </div>

    @endif


    {{-- HEADER --}}

    <div class="admin-header">

        <h1>
            📚 Kelola Buku
        </h1>

        <p>
            Kelola seluruh koleksi buku Galaxy Books.
        </p>

    </div>


    {{-- STATISTIK --}}

    <div class="stats">

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


    {{-- BUTTON --}}

    <div class="admin-actions">

        <a
            href="{{ url('/admin/books/create') }}"
            class="action-btn add-btn"
        >
            ➕ Tambah Buku
        </a>


        <a
            href="{{ url('/admin') }}"
            class="action-btn home-btn"
        >
            ← Kembali ke Dashboard
        </a>


        <a
            href="{{ url('/') }}"
            class="action-btn home-btn"
        >
            🏠 Lihat Website
        </a>

    </div>


    {{-- TABEL --}}

    <div class="table-container">

        <div class="table-header">

            <h2>
                📖 Daftar Buku
            </h2>

            <p>
                Tambah, edit, dan hapus informasi buku.
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
                            Foto
                        </th>

                        <th>
                            Judul
                        </th>

                        <th>
                            Penulis
                        </th>

                        <th>
                            Kategori
                        </th>

                        <th>
                            Deskripsi
                        </th>

                        <th>
                            Harga
                        </th>

                        <th>
                            Stok
                        </th>

                        <th style="width: 210px;">
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


                            {{-- FOTO --}}

                            <td>

                                @if(
                                    !empty($book->image) &&
                                    file_exists(
                                        public_path(
                                            'img/' . $book->image
                                        )
                                    )
                                )

                                    <img
                                        src="{{ asset('img/' . $book->image) }}"
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


                            {{-- KATEGORI --}}

                            <td>

                                @if(!empty($book->category))

                                    <span class="category">
                                        {{ $book->category }}
                                    </span>

                                @else

                                    <span style="color:#94a3b8;">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- DESKRIPSI --}}

                            <td>

                                @if(!empty($book->description))

                                    <div class="description">

                                        {{ \Illuminate\Support\Str::limit(
                                            $book->description,
                                            100
                                        ) }}

                                    </div>

                                @else

                                    <span style="color:#94a3b8;">
                                        Belum ada deskripsi
                                    </span>

                                @endif

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

                            <td style="width: 210px; min-width: 210px; white-space: nowrap;">

                                <div class="book-actions">

                                    <a
                                        href="{{ url('/admin/books/' . $book->id . '/edit') }}"
                                        class="edit-btn"
                                    >
                                        ✏️ Edit
                                    </a>


                                    <form
                                        action="{{ url('/admin/books/' . $book->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus buku {{ $book->title }}?')"
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

                                </div>

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
                    Silakan tambahkan buku pertama.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection