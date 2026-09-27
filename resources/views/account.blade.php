@extends('layouts.app')

@section('content')

<style>
    .account-page {
        max-width: 1050px;
        margin: 35px auto;
        padding: 0 20px;
    }

    .profile-card {
        background: linear-gradient(135deg, #1565c0, #2878e8);
        color: white;
        border-radius: 18px;
        padding: 30px;
        display: flex;
        align-items: center;
        gap: 22px;
        box-shadow: 0 8px 25px rgba(0,0,0,.12);
        margin-bottom: 25px;
    }

    .avatar {
        width: 85px;
        height: 85px;
        border-radius: 50%;
        background: white;
        color: #1565c0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 38px;
        font-weight: bold;
        flex-shrink: 0;
    }

    .profile-info h1 {
        margin: 0 0 8px;
        font-size: 27px;
    }

    .profile-info p {
        margin: 5px 0;
        opacity: .95;
    }

    .role-badge {
        display: inline-block;
        margin-top: 8px;
        padding: 6px 13px;
        background: rgba(255,255,255,.2);
        border-radius: 20px;
        font-size: 13px;
    }

    .section-title {
        font-size: 21px;
        margin: 25px 0 15px;
        color: #222;
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }

    .menu-card {
        background: white;
        border-radius: 15px;
        padding: 22px;
        text-decoration: none;
        color: #222;
        box-shadow: 0 4px 15px rgba(0,0,0,.07);
        border: 1px solid #eee;
        transition: .2s;
    }

    .menu-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 22px rgba(0,0,0,.12);
    }

    .menu-icon {
        font-size: 31px;
        margin-bottom: 10px;
    }

    .menu-card h3 {
        margin: 0 0 6px;
        font-size: 17px;
    }

    .menu-card p {
        margin: 0;
        color: #777;
        font-size: 13px;
    }

    .admin-card {
        background: linear-gradient(135deg, #6a1b9a, #8e24aa);
        color: white;
    }

    .admin-card p {
        color: #eee;
    }

    .logout-box {
        background: white;
        border-radius: 15px;
        padding: 22px;
        margin-top: 25px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(0,0,0,.07);
    }

    .logout-button {
        border: none;
        background: #e53935;
        color: white;
        padding: 11px 22px;
        border-radius: 9px;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
    }

    @media (max-width: 700px) {
        .menu-grid {
            grid-template-columns: 1fr;
        }

        .profile-card {
            padding: 22px;
        }

        .avatar {
            width: 65px;
            height: 65px;
            font-size: 28px;
        }

        .profile-info h1 {
            font-size: 21px;
        }
    }
</style>


<div class="account-page">

    {{-- =========================
         PROFILE USER
    ========================== --}}

    <div class="profile-card">

        <div class="avatar">
            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
        </div>

        <div class="profile-info">

            <h1>
                {{ auth()->user()->name ?? 'Pengguna' }}
            </h1>

            <p>
                📧 {{ auth()->user()->email }}
            </p>

            @if(auth()->user()->is_admin)
                <span class="role-badge">
                    👑 Administrator
                </span>
            @else
                <span class="role-badge">
                    👤 Customer
                </span>
            @endif

        </div>

    </div>


    {{-- =========================
         MENU AKUN
    ========================== --}}

    <h2 class="section-title">
        👤 Akun Saya
    </h2>

    <div class="menu-grid">

        <a href="/orders" class="menu-card">

            <div class="menu-icon">
                📦
            </div>

            <h3>
                Pesanan Saya
            </h3>

            <p>
                Lihat riwayat dan status pesanan
            </p>

        </a>


        <a href="/cart" class="menu-card">

            <div class="menu-icon">
                🛒
            </div>

            <h3>
                Keranjang
            </h3>

            <p>
                Lihat buku yang ada di keranjang
            </p>

        </a>


        <a href="/" class="menu-card">

            <div class="menu-icon">
                📚
            </div>

            <h3>
                Belanja Buku
            </h3>

            <p>
                Cari dan beli buku favoritmu
            </p>

        </a>

    </div>


    {{-- =========================
         ADMIN MENU
    ========================== --}}

    @if(auth()->user()->is_admin)

        <h2 class="section-title">
            👑 Menu Administrator
        </h2>

        <div class="menu-grid">

            <a href="/admin/dashboard" class="menu-card admin-card">

                <div class="menu-icon">
                    👑
                </div>

                <h3>
                    Dashboard Admin
                </h3>

                <p>
                    Kelola seluruh sistem Galaxy Books
                </p>

            </a>


            <a href="/admin/books" class="menu-card admin-card">

                <div class="menu-icon">
                    📚
                </div>

                <h3>
                    Kelola Buku
                </h3>

                <p>
                    Tambah, edit, dan hapus buku
                </p>

            </a>


            <a href="/admin/orders" class="menu-card admin-card">

                <div class="menu-icon">
                    🛍️
                </div>

                <h3>
                    Kelola Pesanan
                </h3>

                <p>
                    Lihat pesanan pelanggan
                </p>

            </a>

        </div>

    @endif


    {{-- =========================
         LOGOUT
    ========================== --}}

    <div class="logout-box">

        <h3 style="margin-top:0;">
            🚪 Keluar dari Akun
        </h3>

        <p style="color:#777;">
            Kamu akan keluar dari akun Galaxy Books.
        </p>

        <form action="/logout" method="POST">

            @csrf

            <button type="submit" class="logout-button">
                🚪 Logout
            </button>

        </form>

    </div>

</div>

@endsection