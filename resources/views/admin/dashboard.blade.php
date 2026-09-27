@extends('layouts.app')

@section('content')

<style>
    .admin-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .admin-header {
        background: linear-gradient(135deg, #111827, #1f2937);
        color: white;
        padding: 30px;
        border-radius: 20px;
        margin-bottom: 25px;
    }

    .admin-header h1 {
        margin: 0 0 8px;
        font-size: 32px;
    }

    .admin-header p {
        margin: 0;
        color: #d1d5db;
    }

    .stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 22px;
        border-radius: 18px;
        box-shadow: 0 5px 20px rgba(0,0,0,.08);
    }

    .stat-icon {
        font-size: 30px;
        margin-bottom: 10px;
    }

    .stat-title {
        color: #6b7280;
        font-size: 14px;
    }

    .stat-number {
        font-size: 28px;
        font-weight: bold;
        margin-top: 5px;
    }

    .admin-section {
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,.08);
        margin-bottom: 25px;
    }

    .admin-section h2 {
        margin-top: 0;
        margin-bottom: 20px;
    }

    .admin-actions {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }

    .admin-action {
        display: block;
        padding: 20px;
        border-radius: 15px;
        text-decoration: none;
        color: #111827;
        background: #f3f4f6;
        transition: .2s;
    }

    .admin-action:hover {
        transform: translateY(-3px);
        background: #e5e7eb;
    }

    .admin-action strong {
        display: block;
        font-size: 18px;
        margin-bottom: 6px;
    }

    .admin-action span {
        color: #6b7280;
        font-size: 14px;
    }

    .book-table {
        width: 100%;
        border-collapse: collapse;
    }

    .book-table th,
    .book-table td {
        padding: 14px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        vertical-align: middle;
    }

    .book-table th {
        background: #f9fafb;
    }

    /* =========================
       TOMBOL EDIT & HAPUS
    ========================= */

    .aksi-buku {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        align-items: center !important;
        gap: 8px !important;
        width: 180px !important;
        min-width: 180px !important;
        white-space: nowrap !important;
    }

    .aksi-buku form {
        display: block !important;
        width: auto !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .btn-edit {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        flex: 0 0 82px !important;
        width: 82px !important;
        min-width: 82px !important;
        max-width: 82px !important;
        height: 36px !important;
        padding: 0 !important;
        margin: 0 !important;
        box-sizing: border-box !important;

        background: #2563eb !important;
        color: white !important;
        border-radius: 8px !important;
        text-decoration: none !important;
        font-size: 13px !important;
        font-weight: bold !important;
        white-space: nowrap !important;
    }

    .btn-edit:hover {
        background: #1d4ed8 !important;
    }

    .btn-delete {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        flex: 0 0 82px !important;
        width: 82px !important;
        min-width: 82px !important;
        max-width: 82px !important;
        height: 36px !important;
        padding: 0 !important;
        margin: 0 !important;
        box-sizing: border-box !important;

        background: #dc2626 !important;
        color: white !important;
        border: none !important;
        border-radius: 8px !important;
        cursor: pointer !important;
        font-size: 13px !important;
        font-weight: bold !important;
        white-space: nowrap !important;
    }

    .btn-delete:hover {
        background: #b91c1c !important;
    }

    .btn-add {
        display: inline-block;
        background: #16a34a;
        color: white;
        padding: 11px 18px;
        border-radius: 10px;
        text-decoration: none;
        margin-bottom: 20px;
    }

    .btn-add:hover {
        background: #15803d;
    }

    @media (max-width: 800px) {

        .stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .admin-actions {
            grid-template-columns: 1fr;
        }

        .book-table {
            min-width: 800px;
        }
    }

    @media (max-width: 500px) {

        .stats {
            grid-template-columns: 1fr;
        }
    }
</style>


<div class="admin-container">


    {{-- HEADER --}}

    <div class="admin-header">

        <h1>
            👑 Admin Dashboard
        </h1>

        <p>
            Selamat datang, {{ auth()->user()->name ?? 'Admin' }}.
            Kelola seluruh sistem Galaxy Books dari sini.
        </p>

    </div>


    {{-- STATISTIK --}}

    <div class="stats">


        <div class="stat-card">

            <div class="stat-icon">
                📚
            </div>

            <div class="stat-title">
                Total Buku
            </div>

            <div class="stat-number">
                {{ \App\Models\Book::count() }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                📦
            </div>

            <div class="stat-title">
                Total Stok
            </div>

            <div class="stat-number">
                {{ \App\Models\Book::sum('stock') }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                ⚠️
            </div>

            <div class="stat-title">
                Stok Habis
            </div>

            <div class="stat-number">
                {{ \App\Models\Book::where('stock', '<=', 0)->count() }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                👥
            </div>

            <div class="stat-title">
                Total User
            </div>

            <div class="stat-number">
                {{ \App\Models\User::count() }}
            </div>

        </div>


    </div>


    {{-- MENU ADMIN --}}

    <div class="admin-section">

        <h2>
            ⚙️ Kontrol Sistem
        </h2>


        <div class="admin-actions">


            <a
                href="/admin/books"
                class="admin-action"
            >

                <strong>
                    📚 Kelola Buku
                </strong>

                <span>
                    Tambah, edit, hapus buku dan stok.
                </span>

            </a>


            <a
                href="/admin/orders"
                class="admin-action"
            >

                <strong>
                    🛒 Kelola Pesanan
                </strong>

                <span>
                    Lihat dan proses pesanan pelanggan.
                </span>

            </a>


            <a
                href="/admin/users"
                class="admin-action"
            >

                <strong>
                    👥 Kelola User
                </strong>

                <span>
                    Lihat pengguna yang terdaftar.
                </span>

            </a>


            <a
                href="/admin/books/create"
                class="admin-action"
            >

                <strong>
                    ➕ Tambah Buku
                </strong>

                <span>
                    Masukkan buku baru ke katalog.
                </span>

            </a>


            <a
                href="/admin/promos"
                class="admin-action"
            >

                <strong>
                    🏷️ Diskon & Event
                </strong>

                <span>
                    Atur harga promo dan periode event.
                </span>

            </a>


            <a
                href="/admin/reports"
                class="admin-action"
            >

                <strong>
                    📊 Laporan
                </strong>

                <span>
                    Lihat laporan penjualan dan stok.
                </span>

            </a>


        </div>

    </div>


    {{-- DAFTAR BUKU --}}

    <div class="admin-section">


        <h2>
            📚 Daftar Buku
        </h2>


        <a
            href="/admin/books/create"
            class="btn-add"
        >
            ➕ Tambah Buku
        </a>


        <div style="overflow-x:auto;">


            <table class="book-table">


                <thead>

                    <tr>

                        <th>
                            ID
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

                        <th style="width:200px;">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>


                    @foreach(\App\Models\Book::all() as $book)


                        <tr>


                            <td>
                                {{ $book->id }}
                            </td>


                            <td>

                                <strong>
                                    {{ $book->title }}
                                </strong>

                            </td>


                            <td>
                                {{ $book->author }}
                            </td>


                            <td>
                                Rp
                                {{ number_format(
                                    $book->price,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </td>


                            <td>


                                @if($book->stock <= 0)

                                    <span
                                        style="
                                            color:#dc2626;
                                            font-weight:bold;
                                        "
                                    >
                                        Habis
                                    </span>

                                @elseif($book->stock <= 5)

                                    <span
                                        style="
                                            color:#d97706;
                                            font-weight:bold;
                                        "
                                    >
                                        {{ $book->stock }} ⚠️
                                    </span>

                                @else

                                    {{ $book->stock }}

                                @endif


                            </td>


                            {{-- AKSI --}}

                            <td
                                style="
                                    width:200px;
                                    min-width:200px;
                                    white-space:nowrap;
                                "
                            >

                                <div class="aksi-buku">


                                    {{-- EDIT --}}

                                    <a
                                        href="/admin/books/{{ $book->id }}/edit"
                                        class="btn-edit"
                                    >
                                        ✏️ Edit
                                    </a>


                                    {{-- HAPUS --}}

                                    <form
                                        action="/admin/books/{{ $book->id }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus buku ini?')"
                                    >

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="btn-delete"
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


        </div>


    </div>


    {{-- INFORMASI SISTEM --}}

    <div class="admin-section">


        <h2>
            💳 Sistem Pembayaran
        </h2>


        <div class="admin-actions">


            <div class="admin-action">

                <strong>
                    📱 QRIS
                </strong>

                <span>
                    Pembayaran menggunakan QRIS.
                </span>

            </div>


            <div class="admin-action">

                <strong>
                    🏦 Transfer Bank
                </strong>

                <span>
                    Pelanggan dapat melakukan transfer.
                </span>

            </div>


            <div class="admin-action">

                <strong>
                    💵 COD
                </strong>

                <span>
                    Pembayaran dilakukan saat barang diterima.
                </span>

            </div>


        </div>


    </div>


</div>


@endsection