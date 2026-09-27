@extends('layouts.app')

@section('content')

<div style="max-width:850px;margin:30px auto;padding:20px;">

    <h1>💳 Pengaturan Pembayaran</h1>

    <p style="color:#666;">
        Semua rekening dan metode pembayaran dapat diatur oleh Admin.
    </p>


    @if(session('success'))

        <div style="background:#dcfce7;color:#166534;padding:15px;border-radius:10px;margin:20px 0;">
            ✅ {{ session('success') }}
        </div>

    @endif


    @if($errors->any())

        <div style="background:#fee2e2;color:#991b1b;padding:15px;border-radius:10px;margin:20px 0;">

            @foreach($errors->all() as $error)

                <div>⚠️ {{ $error }}</div>

            @endforeach

        </div>

    @endif


    <form
        action="/admin/payment-settings"
        method="POST"
        enctype="multipart/form-data"
        style="background:white;padding:25px;border-radius:15px;box-shadow:0 5px 20px rgba(0,0,0,.08);"
    >

        @csrf
        @method('PUT')


        <h2>🏦 Rekening Bank</h2>


        <div style="margin-bottom:18px;">

            <label><strong>Nama Bank</strong></label>

            <input
                type="text"
                name="bank_name"
                value="{{ $settings->bank_name }}"
                placeholder="Contoh: BCA"
                style="width:100%;padding:12px;margin-top:7px;border:1px solid #ddd;border-radius:8px;box-sizing:border-box;"
            >

        </div>


        <div style="margin-bottom:18px;">

            <label><strong>Nomor Rekening</strong></label>

            <input
                type="text"
                name="account_number"
                value="{{ $settings->account_number }}"
                placeholder="Masukkan nomor rekening"
                style="width:100%;padding:12px;margin-top:7px;border:1px solid #ddd;border-radius:8px;box-sizing:border-box;"
            >

        </div>


        <div style="margin-bottom:25px;">

            <label><strong>Atas Nama</strong></label>

            <input
                type="text"
                name="account_holder"
                value="{{ $settings->account_holder }}"
                placeholder="Nama pemilik rekening"
                style="width:100%;padding:12px;margin-top:7px;border:1px solid #ddd;border-radius:8px;box-sizing:border-box;"
            >

        </div>


        <hr style="border:0;border-top:1px solid #eee;margin:25px 0;">


        <h2>💳 Metode Pembayaran</h2>


        <label style="display:block;margin:15px 0;">

            <input
                type="checkbox"
                name="qris_enabled"
                value="1"
                {{ $settings->qris_enabled ? 'checked' : '' }}
            >

            📱 Aktifkan QRIS

        </label>


        <label style="display:block;margin:15px 0;">

            <input
                type="checkbox"
                name="transfer_enabled"
                value="1"
                {{ $settings->transfer_enabled ? 'checked' : '' }}
            >

            🏦 Aktifkan Transfer Bank

        </label>


        <label style="display:block;margin:15px 0 25px;">

            <input
                type="checkbox"
                name="cod_enabled"
                value="1"
                {{ $settings->cod_enabled ? 'checked' : '' }}
            >

            💵 Aktifkan COD

        </label>


        <hr style="border:0;border-top:1px solid #eee;margin:25px 0;">


        <h2>📱 QRIS</h2>


        @if($settings->qris_image)

            <div style="margin:15px 0;">

                <img
                    src="{{ asset('img/' . $settings->qris_image) }}"
                    style="width:220px;max-width:100%;border:1px solid #ddd;border-radius:10px;padding:10px;"
                >

            </div>

        @endif


        <input
            type="file"
            name="qris_image"
            accept="image/*"
            style="margin:10px 0 25px;"
        >


        <button
            type="submit"
            style="width:100%;padding:14px;background:#2563eb;color:white;border:0;border-radius:10px;font-size:16px;font-weight:bold;cursor:pointer;"
        >
            💾 Simpan Pengaturan Pembayaran
        </button>


    </form>

</div>

@endsection