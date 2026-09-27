@extends('layouts.app')

@section('content')

<style>
    .login-page {
        min-height: calc(100vh - 65px);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;

        background:
            radial-gradient(circle at top left, #dbeafe, transparent 35%),
            radial-gradient(circle at bottom right, #dcfce7, transparent 35%),
            #f4f7ff;
    }

    .login-card {
        width: 100%;
        max-width: 430px;
        background: white;
        padding: 35px;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    .login-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 15px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #dbeafe;
        border-radius: 50%;

        font-size: 32px;
    }

    .login-title {
        text-align: center;
        margin-bottom: 5px;
        font-size: 28px;
        font-weight: bold;
        color: #111827;
    }

    .login-subtitle {
        text-align: center;
        color: #6b7280;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #111827;
    }

    .form-group input {
        width: 100%;
        box-sizing: border-box;
        padding: 13px 15px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 15px;
        outline: none;
        transition: 0.2s;
    }

    .form-group input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .login-button {
        width: 100%;
        border: none;
        padding: 13px;
        border-radius: 10px;

        background: linear-gradient(90deg, #075985, #2563eb);

        color: white;
        font-size: 16px;
        font-weight: bold;

        cursor: pointer;
        transition: 0.2s;
    }

    .login-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(37, 99, 235, 0.25);
    }

    .error-box {
        background: #fee2e2;
        color: #b91c1c;
        padding: 12px 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .register-text {
        text-align: center;
        margin-top: 25px;
        color: #6b7280;
    }

    .register-text a {
        color: #16a34a;
        font-weight: bold;
        text-decoration: none;
    }

    .register-text a:hover {
        text-decoration: underline;
    }

    .security-note {
        margin-top: 20px;
        padding: 12px;
        background: #ecfdf5;
        border-radius: 10px;
        color: #166534;
        font-size: 13px;
        text-align: center;
    }
</style>


<div class="login-page">

    <div class="login-card">

        <div class="login-icon">
            🔐
        </div>


        <div class="login-title">
            Login
        </div>


        <div class="login-subtitle">
            Masuk ke akun Galaxy Books
        </div>


        @if ($errors->any())

            <div class="error-box">

                @foreach ($errors->all() as $error)

                    <div>
                        ⚠️ {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif


        {{-- FORM LOGIN --}}

        <form
            action="{{ route('login.process') }}"
            method="POST"
            autocomplete="off"
        >

            @csrf


            {{-- EMAIL --}}

            <div class="form-group">

                <label for="email">
                    📧 Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email"
                    autocomplete="email"
                    required
                >

            </div>


            {{-- PASSWORD --}}

            <div class="form-group">

                <label for="password">
                    🔑 Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    required
                >

            </div>


            {{-- LOGIN BUTTON --}}

            <button
                type="submit"
                class="login-button"
            >
                🔐 Login
            </button>

        </form>


        <div class="security-note">
            🔒 Jangan bagikan password akunmu kepada orang lain.
        </div>


        <div class="register-text">

            Belum punya akun?

            <a href="{{ route('register') }}">
                Daftar di sini
            </a>

        </div>

    </div>

</div>

@endsection