@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')

<style>
    .form-container {
        max-width: 850px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .form-card {
        background: white;
        padding: 30px;
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(0,0,0,.08);
    }

    .form-title {
        margin: 0 0 8px;
        font-size: 28px;
        color: #111827;
    }

    .form-subtitle {
        margin: 0 0 25px;
        color: #64748b;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 7px;
        font-weight: 700;
        color: #374151;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 12px 14px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        font-size: 14px;
        outline: none;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #2563eb;
    }

    .form-group textarea {
        min-height: 150px;
        resize: vertical;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .error {
        color: #dc2626;
        font-size: 13px;
        margin-top: 5px;
    }

    .button-area {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }

    .btn {
        border: none;
        padding: 12px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-save {
        background: #16a34a;
        color: white;
    }

    .btn-back {
        background: #e5e7eb;
        color: #374151;
    }

    @media (max-width: 650px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="form-container">

    <div class="form-card">

        <h1 class="form-title">
            ➕ Tambah Buku
        </h1>

        <p class="form-subtitle">
            Tambahkan buku baru ke koleksi Galaxy Books.
        </p>


        <form
            action="{{ url('/books') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


            {{-- JUDUL --}}

            <div class="form-group">

                <label>
                    Judul Buku
                </label>

                <input
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="Masukkan judul buku"
                    required
                >

                @error('title')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- PENULIS --}}

            <div class="form-group">

                <label>
                    Penulis
                </label>

                <input
                    type="text"
                    name="author"
                    value="{{ old('author') }}"
                    placeholder="Masukkan nama penulis"
                    required
                >

                @error('author')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- KATEGORI --}}

            <div class="form-group">

                <label>
                    Kategori
                </label>

                <select name="category">

                    <option value="">
                        -- Pilih Kategori --
                    </option>

                    @foreach([
                        'Pendidikan',
                        'Self Improvement',
                        'Sains',
                        'Novel',
                        'Psikologi',
                        'Bisnis & Keuangan',
                        'Sejarah & Geografi',
                        'Agama & Spiritual',
                        'Teknologi & Komputer',
                        'Lainnya'
                    ] as $category)

                        <option
                            value="{{ $category }}"
                            {{ old('category') == $category ? 'selected' : '' }}
                        >
                            {{ $category }}
                        </option>

                    @endforeach

                </select>

                @error('category')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- DESKRIPSI --}}

            <div class="form-group">

                <label>
                    Deskripsi Buku
                </label>

                <textarea
                    name="description"
                    placeholder="Masukkan deskripsi atau ringkasan buku..."
                >{{ old('description') }}</textarea>

                @error('description')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- HARGA + STOK --}}

            <div class="form-row">

                <div class="form-group">

                    <label>
                        Harga
                    </label>

                    <input
                        type="number"
                        name="price"
                        value="{{ old('price') }}"
                        min="0"
                        placeholder="85000"
                        required
                    >

                    @error('price')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        Stok
                    </label>

                    <input
                        type="number"
                        name="stock"
                        value="{{ old('stock') }}"
                        min="0"
                        placeholder="10"
                        required
                    >

                    @error('stock')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>


            {{-- GAMBAR --}}

            <div class="form-group">

                <label>
                    Foto Sampul Buku
                </label>

                <input
                    type="file"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <small style="color:#64748b;">
                    Format: JPG, JPEG, PNG, WEBP. Maksimal 10 MB.
                </small>

                @error('image')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- BUTTON --}}

            <div class="button-area">

                <button
                    type="submit"
                    class="btn btn-save"
                >
                    💾 Simpan Buku
                </button>

                <a
                    href="{{ url('/admin') }}"
                    class="btn btn-back"
                >
                    ← Kembali
                </a>

            </div>

        </form>

    </div>

</div>

@endsection