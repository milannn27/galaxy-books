@extends('layouts.app')

@section('content')

<style>
    .expense-container {
        width: 94%;
        max-width: 1200px;
        margin: 30px auto;
    }

    .expense-header {
        margin-bottom: 25px;
    }

    .expense-header h1 {
        margin: 0;
        color: #111827;
    }

    .expense-header p {
        color: #64748b;
        margin-top: 6px;
    }

    .card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 8px 25px rgba(0,0,0,.07);
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .form-group label {
        font-weight: bold;
        color: #334155;
    }

    .form-group input,
    .form-group select {
        padding: 12px;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        font-size: 14px;
    }

    .full {
        grid-column: 1 / -1;
    }

    .btn {
        border: none;
        padding: 12px 20px;
        border-radius: 9px;
        background: #16a34a;
        color: white;
        font-weight: bold;
        cursor: pointer;
        font-size: 14px;
    }

    .btn:hover {
        background: #15803d;
    }

    .total-box {
        background: #fef2f2;
        border-radius: 12px;
        padding: 18px;
        margin-bottom: 20px;
    }

    .total-box span {
        color: #991b1b;
        font-weight: bold;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 13px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
    }

    th {
        background: #f8fafc;
        color: #334155;
    }

    .delete-btn {
        background: #dc2626;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 7px;
        cursor: pointer;
        font-weight: bold;
    }

    .success {
        background: #dcfce7;
        color: #166534;
        padding: 14px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-weight: bold;
    }

    .error {
        background: #fee2e2;
        color: #991b1b;
        padding: 14px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    @media (max-width: 700px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .full {
            grid-column: auto;
        }
    }
</style>

<div class="expense-container">

    <div class="expense-header">
        <h1>📦 Restock & Pengeluaran</h1>

        <p>
            Tambahkan stok buku sekaligus mencatat biaya pembelian buku.
        </p>
    </div>

    @if(session('success'))
        <div class="success">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="error">
            <strong>Terjadi kesalahan:</strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">

        <h2>➕ Tambah Restock</h2>

        <form
            action="/admin/expenses"
            method="POST"
        >

            @csrf

            <div class="form-grid">

                <div class="form-group full">

                    <label>
                        Pilih Buku
                    </label>

                    <select
                        name="book_id"
                        required
                    >

                        <option value="">
                            -- Pilih Buku --
                        </option>

                        @foreach($books as $book)

                            <option value="{{ $book->id }}">

                                {{ $book->title }}

                                —
                                Stok sekarang:
                                {{ $book->stock }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="form-group">

                    <label>
                        Jumlah Restock
                    </label>

                    <input
                        type="number"
                        name="quantity"
                        min="1"
                        placeholder="Contoh: 20"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>
                        Harga Beli per Buku
                    </label>

                    <input
                        type="number"
                        name="unit_price"
                        min="0"
                        placeholder="Contoh: 35000"
                        required
                    >

                </div>

                <div class="form-group full">

                    <label>
                        Keterangan
                    </label>

                    <input
                        type="text"
                        name="description"
                        placeholder="Contoh: Pembelian stok dari supplier"
                    >

                </div>

                <div class="full">

                    <button
                        type="submit"
                        class="btn"
                    >
                        📦 Simpan Restock
                    </button>

                </div>

            </div>

        </form>

    </div>

    <div class="total-box">

        💸 Total seluruh pengeluaran restock:

        <span>
            Rp {{ number_format($totalExpense, 0, ',', '.') }}
        </span>

    </div>

    <div class="card">

        <h2>📋 Riwayat Pengeluaran</h2>

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            Buku
                        </th>

                        <th>
                            Jumlah
                        </th>

                        <th>
                            Harga Beli
                        </th>

                        <th>
                            Total
                        </th>

                        <th>
                            Keterangan
                        </th>

                        <th>
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($expenses as $expense)

                        <tr>

                            <td>
                                {{ $expense->created_at->format('d-m-Y H:i') }}
                            </td>

                            <td>
                                {{ $expense->book->title ?? '-' }}
                            </td>

                            <td>
                                {{ $expense->quantity }}
                            </td>

                            <td>
                                Rp {{ number_format($expense->unit_price, 0, ',', '.') }}
                            </td>

                            <td>
                                <strong>
                                    Rp {{ number_format($expense->total, 0, ',', '.') }}
                                </strong>
                            </td>

                            <td>
                                {{ $expense->description }}
                            </td>

                            <td>

                                <form
                                    action="/admin/expenses/{{ $expense->id }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus data pengeluaran ini? Stok juga akan dikurangi kembali.')"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="delete-btn"
                                    >
                                        🗑 Hapus
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                style="text-align:center;"
                            >
                                Belum ada data pengeluaran.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection