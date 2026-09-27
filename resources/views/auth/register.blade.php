@extends('layouts.app')

@section('content')

<style>
    .register-wrapper {
        min-height: 75vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;
    }

    .register-box {
        width: 420px;
        max-width: 100%;
        background: white;
        padding: 35px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,.10);
    }

    .register-icon {
        width: 60px;
        height: 60px;
        margin: auto;
        border-radius: 50%;
        background: #e0f2fe;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .register-title {
        text-align: center;
        margin-top: 15px;
        margin-bottom: 5px;
    }

    .register-subtitle {
        text-align: center;
        color: #777;
        margin-bottom: 25px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 7px;
    }

    .form-group input {
        width: 100%;
        box-sizing: border-box;
        padding: 13px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        font-size: 15px;
    }

    .register-btn {
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 10px;
        background: #2563eb;
        color: white;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
    }

    .register-btn:hover {
        background: #1d4ed8;
    }

    .error-box {
        background: #fee2e2;
        color: #991b1b;
        padding: 12px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .login-link {
        text-align: center;
        margin-top: 20px;
    }

    .login-link a {
        color: #2563eb;
        font-weight: bold;
        text-decoration: none;
    }
</style>


<div class="register-wrapper">

    <div class="register-box">

        <div class="register-icon">
            👤
        </div>

        <h1 class="register-title">
            Daftar Akun
        </h1>

        <p class="register-subtitle">
            Buat akun Galaxy Books
        </p>


        @if($errors->any())

            <div class="error-box">

                @foreach($errors->all() as $error)

                    <div>⚠️ {{ $error }}</div>

                @endforeach

            </div>

        @endif


        <form action="/register" method="POST">

            @csrf


            <div class="form-group">

                <label>
                    👤 Nama
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama"
                    required
                    autofocus
                >

            </div>


            <div class="form-group">

                <label>
                    📧 Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    🔑 Password
                </label>

                <input
                    type="password"
                    name="password"
                    placeholder="Minimal 6 karakter"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    🔐 Konfirmasi Password
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    placeholder="Ulangi password"
                    required
                >

            </div>


            <button
                type="submit"
                class="register-btn"
            >
                📝 Daftar
            </button>

        </form>


        <div class="login-link">

            Sudah punya akun?

            <a href="/login">
                Login di sini
            </a>

        </div>

    </div>

</div>

@endsection