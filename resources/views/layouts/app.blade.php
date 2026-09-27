<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Galaxy Books</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7ff;
            color: #111827;
        }

        /* =========================
           NAVBAR
        ========================= */

        .navbar {
            background: linear-gradient(90deg, #075985, #2563eb);
            padding: 14px 6%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .logo {
            font-size: 25px;
            font-weight: bold;
        }

        .logo span {
            color: #ffd43b;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 9px;
            font-weight: bold;
            transition: 0.2s;
        }

        .nav-menu a:hover {
            background: rgba(255,255,255,0.15);
        }

        /* =========================
           TOMBOL
        ========================= */

        .cart-btn {
            background: #ffd43b !important;
            color: #111827 !important;
        }

        .admin-btn {
            background: #16a34a;
        }

        .account-btn {
            background: #7c3aed !important;
            color: white !important;
        }

        .login-btn {
            background: #111827;
        }

        .logout-btn {
            background: #dc2626;
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 9px;
            font-weight: bold;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: #b91c1c;
        }

        /* =========================
           CONTENT
        ========================= */

        .content {
            min-height: calc(100vh - 75px);
        }

        /* =========================
           ALERT
        ========================= */

        .success-message {
            width: 90%;
            max-width: 1100px;
            margin: 20px auto 0;
            padding: 14px 18px;
            background: #dcfce7;
            color: #166534;
            border-left: 5px solid #16a34a;
            border-radius: 8px;
            font-weight: bold;
        }

        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 700px) {

            .navbar {
                flex-direction: column;
                gap: 12px;
                padding: 15px;
            }

            .nav-menu {
                flex-wrap: wrap;
                justify-content: center;
            }

            .nav-menu a {
                font-size: 14px;
                padding: 8px 11px;
            }

        }

    </style>

</head>


<body>


{{-- =========================
     NAVBAR
========================= --}}

<nav class="navbar">


    {{-- LOGO --}}

    <div class="logo">

        📚 Galaxy <span>Books</span>

    </div>


    <div class="nav-menu">


        {{-- HOME --}}

        <a href="/">
            🏠 Home
        </a>


        {{-- =========================
             KHUSUS ADMIN
        ========================= --}}

        @auth

            @if(auth()->user()->is_admin)

                <a
                    href="/admin/dashboard"
                    class="admin-btn"
                >
                    👑 Admin Dashboard
                </a>

            @endif

        @endauth


        {{-- =========================
             KERANJANG
             USER SAJA
        ========================= --}}

        @auth

            @if(!auth()->user()->is_admin)

                <a
                    href="/cart"
                    class="cart-btn"
                >
                    🛒 Keranjang
                </a>

            @endif

        @endauth


        {{-- =========================
             PESANAN
             USER SAJA
        ========================= --}}

        @auth

            @if(!auth()->user()->is_admin)

                <a
                    href="/orders"
                    class="cart-btn"
                >
                    📦 Pesanan
                </a>

            @endif

        @endauth


        {{-- =========================
             AKUN USER
        ========================= --}}

        @auth

            @if(!auth()->user()->is_admin)

                <a
                    href="/account"
                    class="account-btn"
                >
                    👤 Akun
                </a>

            @endif

        @endauth


        {{-- =========================
             LOGIN / LOGOUT
        ========================= --}}

        @guest

            <a
                href="/login"
                class="login-btn"
            >
                🔐 Login
            </a>

        @else

            <form
                action="/logout"
                method="POST"
                style="margin:0;"
            >

                @csrf

                <button
                    type="submit"
                    class="logout-btn"
                >
                    🚪 Logout
                </button>

            </form>

        @endguest


    </div>

</nav>


{{-- =========================
     PESAN SUKSES
========================= --}}

@if(session('success'))

    <div class="success-message">

        ✅ {{ session('success') }}

    </div>

@endif


{{-- =========================
     CONTENT
========================= --}}

<div class="content">

    @yield('content')

</div>


</body>

</html>