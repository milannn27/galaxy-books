<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Galaxy Books</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #172033;
        }

        .navbar {
            background: linear-gradient(90deg, #075985, #2563eb);
            color: white;
            padding: 16px 6%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            font-size: 21px;
            font-weight: bold;
        }

        .nav-buttons a {
            color: white;
            text-decoration: none;
            margin-left: 10px;
            padding: 9px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: bold;
        }

        .home {
            background: #16a34a;
        }

        .dashboard {
            background: #7c3aed;
        }

        .container {
            max-width: 1200px;
            margin: 35px auto;
            padding: 0 20px 50px;
        }

        .title-box {
            background: #172033;
            color: white;
            padding: 25px;
            border-radius: 18px;
            margin-bottom: 25px;
        }

        .title-box h1 {
            margin: 0 0 8px;
        }

        .title-box p {
            margin: 0;
            color: #cbd5e1;
        }

        .section {
            background: white;
            padding: 25px;
            border-radius: 18px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,.06);
        }

        .section h2 {
            margin-top: 0;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .card {
            background: #f8fafc;
            padding: 20px;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
        }

        .card .label {
            color: #64748b;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .card .value {
            font-size: 23px;
            font-weight: bold;
        }

        .green {
            color: #15803d;
        }

        .red {
            color: #dc2626;
        }

        .blue {
            color: #2563eb;
        }

        .purple {
            color: #7c3aed;
        }

        .orange {
            color: #ea580c;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .summary-card {
            padding: 22px;
            border-radius: 15px;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
        }

        .summary-card h3 {
            margin-top: 0;
        }

        .summary-card .big {
            font-size: 25px;
            font-weight: bold;
            margin: 12px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background: #eff6ff;
            text-align: left;
            padding: 12px;
            font-size: 13px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
            font-size: 14px;
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 9px;
            font-size: 14px;
        }

        .btn {
            border: 0;
            padding: 12px 18px;
            border-radius: 9px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-restock {
            background: #16a34a;
            color: white;
        }

        .btn-delete {
            background: #dc2626;
            color: white;
            padding: 7px 10px;
            border: 0;
            border-radius: 7px;
            cursor: pointer;
        }

        .note {
            background: #eff6ff;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            color: #1e40af;
        }

        .empty {
            text-align: center;
            padding: 25px;
            color: #64748b;
        }

        .period-title {
            margin-top: 25px;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .finance-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .finance-card {
            background: #f8fafc;
            padding: 20px;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
        }

        .finance-card .label {
            color: #64748b;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .finance-card .amount {
            font-size: 23px;
            font-weight: bold;
        }

        .modal-form {
            background: #eff6ff;
            padding: 18px;
            border-radius: 12px;
            margin-bottom: 18px;
        }

        .modal-form-row {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 12px;
            align-items: end;
        }

        .btn-modal {
            background: #2563eb;
            color: white;
        }

        @media(max-width:900px) {
            .finance-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:600px) {
            .finance-grid {
                grid-template-columns: 1fr;
            }

            .modal-form-row {
                grid-template-columns: 1fr;
            }
        }

        @media(max-width:900px) {

            .cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .summary {
                grid-template-columns: 1fr;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

        }

        @media(max-width:600px) {

            .cards {
                grid-template-columns: 1fr;
            }

            .navbar {
                display: block;
            }

            .nav-buttons {
                margin-top: 12px;
            }

            .nav-buttons a {
                display: inline-block;
                margin: 3px;
            }

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

        }

    </style>

</head>

<body>

    <div class="navbar">

        <div class="brand">
            📚 Galaxy Books
        </div>

        <div class="nav-buttons">

            <a href="/" class="home">
                🏠 Home
            </a>

            <a href="/admin" class="dashboard">
                👑 Dashboard
            </a>

        </div>

    </div>


    <div class="container">


        <div class="title-box">

            <h1>
                📊 Laporan Galaxy Books
            </h1>

            <p>
                Semua pemasukan, penjualan, pengeluaran dan restock dalam satu halaman.
            </p>

        </div>


        <!-- MODAL & SALDO -->

        <div class="section">

            <h2>
                💰 Modal & Saldo Keuangan
            </h2>

            <div class="note">
                Masukkan <b>modal awal</b> usaha. Nilai ini disimpan di browser admin dan akan digunakan untuk menghitung saldo akhir.
            </div>

            <div class="modal-form">

                <div class="modal-form-row">

                    <div class="form-group" style="margin-bottom:0;">
                        <label for="modalAwalInput">💵 Modal Awal</label>
                        <input
                            type="number"
                            id="modalAwalInput"
                            min="0"
                            step="1"
                            placeholder="Contoh: 10000000"
                        >
                    </div>

                    <button
                        type="button"
                        class="btn btn-modal"
                        onclick="simpanModalAwal()"
                    >
                        💾 Simpan Modal
                    </button>

                </div>

                <div id="modalStatus" style="margin-top:10px;font-size:13px;font-weight:bold;"></div>

            </div>

            <div class="finance-grid">

                <div class="finance-card">
                    <div class="label">💰 Modal Awal</div>
                    <div class="amount blue" id="modalAwalDisplay">Rp 0</div>
                </div>

                <div class="finance-card">
                    <div class="label">💵 Total Uang Masuk</div>
                    <div class="amount green">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </div>
                </div>

                <div class="finance-card">
                    <div class="label">💸 Total Uang Keluar</div>
                    <div class="amount red">
                        Rp {{ number_format($totalExpense, 0, ',', '.') }}
                    </div>
                </div>

                <div class="finance-card">
                    <div class="label">🧮 Saldo Akhir</div>
                    <div class="amount green" id="saldoAkhirDisplay">Rp 0</div>
                </div>

            </div>

            <div class="note" style="margin-top:15px;margin-bottom:0;">
                <b>Rumus:</b> Saldo Akhir = Modal Awal + Total Uang Masuk − Total Uang Keluar
            </div>

        </div>


        <!-- STATISTIK UMUM -->

        <div class="section">

            <h2>
                📦 Ringkasan Sistem
            </h2>

            <div class="cards">

                <div class="card">
                    <div class="label">📚 Total Buku</div>
                    <div class="value blue">
                        {{ $bookCount }}
                    </div>
                </div>

                <div class="card">
                    <div class="label">📦 Total Stok</div>
                    <div class="value purple">
                        {{ $totalStock }}
                    </div>
                </div>

                <div class="card">
                    <div class="label">👥 Total User</div>
                    <div class="value">
                        {{ $userCount }}
                    </div>
                </div>

                <div class="card">
                    <div class="label">🛒 Pesanan Dibayar</div>
                    <div class="value green">
                        {{ $orderCount }}
                    </div>
                </div>

            </div>

        </div>


        <!-- PENDAPATAN -->

        <div class="section">

            <h2>
                💰 Pendapatan
            </h2>

            <div class="cards">

                <div class="card">
                    <div class="label">Hari Ini</div>
                    <div class="value green">
                        Rp {{ number_format($todayRevenue, 0, ',', '.') }}
                    </div>
                </div>

                <div class="card">
                    <div class="label">Minggu Ini</div>
                    <div class="value green">
                        Rp {{ number_format($weeklyRevenue, 0, ',', '.') }}
                    </div>
                </div>

                <div class="card">
                    <div class="label">Bulan Ini</div>
                    <div class="value green">
                        Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}
                    </div>
                </div>

                <div class="card">
                    <div class="label">Tahun Ini</div>
                    <div class="value green">
                        Rp {{ number_format($yearlyRevenue, 0, ',', '.') }}
                    </div>
                </div>

            </div>

            <div class="card" style="margin-top:15px;">

                <div class="label">
                    Total seluruh pendapatan
                </div>

                <div class="value green">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </div>

            </div>

        </div>


        <!-- PENJUALAN BUKU -->

        <div class="section">

            <h2>
                📚 Penjualan Buku
            </h2>

            <div class="cards">

                <div class="card">
                    <div class="label">
                        Buku Terjual Minggu Ini
                    </div>

                    <div class="value blue">
                        {{ $weeklyBooksSold }} buku
                    </div>
                </div>

                <div class="card">
                    <div class="label">
                        Buku Terjual Bulan Ini
                    </div>

                    <div class="value blue">
                        {{ $monthlyBooksSold }} buku
                    </div>
                </div>

                <div class="card">
                    <div class="label">
                        Buku Terjual Tahun Ini
                    </div>

                    <div class="value blue">
                        {{ $yearlyBooksSold }} buku
                    </div>
                </div>

            </div>


            <h3 class="period-title">
                📅 Penjualan Per Buku — Minggu Ini
            </h3>

            @if($weeklyBookSales->count() > 0)

                <table>

                    <thead>

                        <tr>
                            <th>No</th>
                            <th>Nama Buku</th>
                            <th>Terjual</th>
                            <th>Pendapatan</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($weeklyBookSales as $index => $sale)

                            <tr>

                                <td>
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    {{ $sale->title }}
                                </td>

                                <td>
                                    {{ $sale->total_qty }} buku
                                </td>

                                <td class="green">
                                    Rp {{ number_format($sale->total_sales, 0, ',', '.') }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <div class="empty">
                    Belum ada penjualan buku minggu ini.
                </div>

            @endif


            <h3 class="period-title">
                📅 Penjualan Per Buku — Bulan Ini
            </h3>

            @if($monthlyBookSales->count() > 0)

                <table>

                    <thead>

                        <tr>
                            <th>No</th>
                            <th>Nama Buku</th>
                            <th>Terjual</th>
                            <th>Pendapatan</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($monthlyBookSales as $index => $sale)

                            <tr>

                                <td>
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    {{ $sale->title }}
                                </td>

                                <td>
                                    {{ $sale->total_qty }} buku
                                </td>

                                <td class="green">
                                    Rp {{ number_format($sale->total_sales, 0, ',', '.') }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <div class="empty">
                    Belum ada penjualan buku bulan ini.
                </div>

            @endif

        </div>


        <!-- PENGELUARAN -->

        <div class="section">

            <h2>
                💸 Pengeluaran & Hasil Bersih
            </h2>

            <div class="summary">

                <div class="summary-card">

                    <h3>
                        📅 Minggu Ini
                    </h3>

                    <div>
                        Pendapatan
                    </div>

                    <div class="big green">
                        Rp {{ number_format($weeklyRevenue, 0, ',', '.') }}
                    </div>

                    <div>
                        Pengeluaran
                    </div>

                    <div class="big red">
                        Rp {{ number_format($weeklyExpense, 0, ',', '.') }}
                    </div>

                    <div>
                        Hasil Bersih
                    </div>

                    <div class="big {{ $weeklyNet >= 0 ? 'green' : 'red' }}">
                        Rp {{ number_format($weeklyNet, 0, ',', '.') }}
                    </div>

                </div>


                <div class="summary-card">

                    <h3>
                        📅 Bulan Ini
                    </h3>

                    <div>
                        Pendapatan
                    </div>

                    <div class="big green">
                        Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}
                    </div>

                    <div>
                        Pengeluaran
                    </div>

                    <div class="big red">
                        Rp {{ number_format($monthlyExpense, 0, ',', '.') }}
                    </div>

                    <div>
                        Hasil Bersih
                    </div>

                    <div class="big {{ $monthlyNet >= 0 ? 'green' : 'red' }}">
                        Rp {{ number_format($monthlyNet, 0, ',', '.') }}
                    </div>

                </div>


                <div class="summary-card">

                    <h3>
                        📅 Tahun Ini
                    </h3>

                    <div>
                        Pendapatan
                    </div>

                    <div class="big green">
                        Rp {{ number_format($yearlyRevenue, 0, ',', '.') }}
                    </div>

                    <div>
                        Pengeluaran
                    </div>

                    <div class="big red">
                        Rp {{ number_format($yearlyExpense, 0, ',', '.') }}
                    </div>

                    <div>
                        Hasil Bersih
                    </div>

                    <div class="big {{ $yearlyNet >= 0 ? 'green' : 'red' }}">
                        Rp {{ number_format($yearlyNet, 0, ',', '.') }}
                    </div>

                </div>

            </div>


            <div class="card" style="margin-top:20px;">

                <div class="label">
                    💸 Total seluruh pengeluaran
                </div>

                <div class="value red">
                    Rp {{ number_format($totalExpense, 0, ',', '.') }}
                </div>

            </div>

        </div>


        <!-- RESTOCK -->

        <div class="section">

            <h2>
                📦 Restock Buku
            </h2>

            <div class="note">

                💡 <b>Contoh:</b>
                Jika stok buku Bulan = 67 dan kamu restock 20 buku,
                maka stok otomatis menjadi <b>87</b>.
                Jika harga beli Rp35.000 per buku,
                pengeluaran otomatis tercatat sebesar
                <b>Rp700.000</b>.

            </div>


            <form
                action="{{ route('admin.expenses.store') }}"
                method="POST"
            >

                @csrf

                <div class="form-grid">

                    <div class="form-group">

                        <label>
                            📚 Pilih Buku
                        </label>

                        <select name="book_id" required>

                            <option value="">
                                -- Pilih Buku --
                            </option>

                            @foreach($books as $book)

                                <option value="{{ $book->id }}">

                                    {{ $book->title }}
                                    — Stok {{ $book->stock }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="form-group">

                        <label>
                            📦 Jumlah Restock
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
                            💰 Harga Beli / Buku
                        </label>

                        <input
                            type="number"
                            name="unit_price"
                            min="0"
                            placeholder="Contoh: 35000"
                            required
                        >

                    </div>

                </div>


                <div class="form-group">

                    <label>
                        📝 Keterangan
                    </label>

                    <input
                        type="text"
                        name="description"
                        placeholder="Contoh: Restock buku Bulan dari supplier"
                    >

                </div>


                <button
                    type="submit"
                    class="btn btn-restock"
                >
                    📦 Simpan Restock
                </button>

            </form>

        </div>


        <!-- RIWAYAT RESTOCK -->

        <div class="section">

            <h2>
                📋 Riwayat Restock
            </h2>

            @if($expenses->count() > 0)

                <table>

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Tanggal</th>

                            <th>Buku</th>

                            <th>Jumlah</th>

                            <th>Harga Beli</th>

                            <th>Total</th>

                            <th>Keterangan</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($expenses as $index => $expense)

                            <tr>

                                <td>
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    {{ date('d-m-Y H:i', strtotime($expense->created_at)) }}
                                </td>

                                <td>
                                    {{ $expense->book_title ?? 'Buku dihapus' }}
                                </td>

                                <td>
                                    {{ $expense->quantity }}
                                </td>

                                <td>
                                    Rp {{ number_format($expense->unit_price, 0, ',', '.') }}
                                </td>

                                <td class="red">
                                    Rp {{ number_format($expense->total, 0, ',', '.') }}
                                </td>

                                <td>
                                    {{ $expense->description }}
                                </td>

                                <td>

                                    <form
                                        action="{{ route('admin.expenses.destroy', $expense->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus data restock ini?')"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn-delete"
                                        >
                                            🗑️
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <div class="empty">
                    Belum ada data restock.
                </div>

            @endif

        </div>


        <!-- PENDAPATAN HARIAN -->

        <div class="section">

            <h2>
                📈 Pendapatan Harian Minggu Ini
            </h2>

            @if($dailyRevenue->count() > 0)

                <table>

                    <thead>

                        <tr>
                            <th>Tanggal</th>
                            <th>Pendapatan</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($dailyRevenue as $day)

                            <tr>

                                <td>
                                    {{ date('d-m-Y', strtotime($day->tanggal)) }}
                                </td>

                                <td class="green">
                                    Rp {{ number_format($day->pendapatan, 0, ',', '.') }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <div class="empty">
                    Belum ada pendapatan minggu ini.
                </div>

            @endif

        </div>


        <!-- PENDAPATAN BULANAN TAHUN INI -->

        <div class="section">

            <h2>
                📊 Pendapatan Bulanan Tahun Ini
            </h2>

            @if($monthlyRevenueChart->count() > 0)

                <table>

                    <thead>

                        <tr>
                            <th>Bulan</th>
                            <th>Pendapatan</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($monthlyRevenueChart as $month)

                            <tr>

                                @php
                                    $monthDate = data_get($month, 'bulan')
                                        ?? data_get($month, 'month')
                                        ?? data_get($month, 'tanggal')
                                        ?? null;

                                    $monthRevenue = data_get($month, 'pendapatan')
                                        ?? data_get($month, 'revenue')
                                        ?? data_get($month, 'total_revenue')
                                        ?? data_get($month, 'total_sales')
                                        ?? data_get($month, 'total')
                                        ?? 0;
                                @endphp

                                <td>
                                    @if($monthDate)
                                        {{ date('F Y', strtotime($monthDate . (strlen((string) $monthDate) <= 2 ? '-01' : ''))) }}
                                    @else
                                        Bulan tidak tersedia
                                    @endif
                                </td>

                                <td class="green">
                                    Rp {{ number_format((float) $monthRevenue, 0, ',', '.') }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <div class="empty">
                    Belum ada data pendapatan tahun ini.
                </div>

            @endif

        </div>


    </div>



    <script>

        const totalUangMasuk = {{ (float) $totalRevenue }};
        const totalUangKeluar = {{ (float) $totalExpense }};

        function formatRupiah(angka) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
        }

        function tampilkanKeuangan() {
            const modal = parseFloat(localStorage.getItem('galaxy_books_modal_awal') || '0') || 0;
            const saldo = modal + totalUangMasuk - totalUangKeluar;

            document.getElementById('modalAwalInput').value = modal > 0 ? modal : '';
            document.getElementById('modalAwalDisplay').textContent = formatRupiah(modal);

            const saldoElement = document.getElementById('saldoAkhirDisplay');
            saldoElement.textContent = formatRupiah(saldo);
            saldoElement.classList.remove('green', 'red');
            saldoElement.classList.add(saldo >= 0 ? 'green' : 'red');
        }

        function simpanModalAwal() {
            const input = document.getElementById('modalAwalInput');
            const status = document.getElementById('modalStatus');
            const modal = parseFloat(input.value);

            if (isNaN(modal) || modal < 0) {
                status.textContent = '⚠️ Masukkan modal awal yang valid.';
                status.style.color = '#dc2626';
                return;
            }

            localStorage.setItem('galaxy_books_modal_awal', modal);
            status.textContent = '✅ Modal awal berhasil disimpan.';
            status.style.color = '#15803d';
            tampilkanKeuangan();
        }

        document.addEventListener('DOMContentLoaded', tampilkanKeuangan);

    </script>

</body>

</html>