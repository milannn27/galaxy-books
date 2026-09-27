<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HOME
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $books = Book::orderBy('id', 'desc')->get();

        return view(
            'books',
            compact('books')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TAMBAH BUKU
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('books.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);


        /*
        |--------------------------------------------------------------------------
        | UPLOAD FOTO
        |--------------------------------------------------------------------------
        */

        $imageName = null;

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $destination = public_path('img');

            if (!is_dir($destination)) {
                mkdir(
                    $destination,
                    0777,
                    true
                );
            }


            $originalName =
                $image->getClientOriginalName();


            $cleanName = preg_replace(
                '/[^A-Za-z0-9._-]/',
                '_',
                $originalName
            );


            $imageName =
                time() . '_' . $cleanName;


            $targetPath =
                $destination .
                DIRECTORY_SEPARATOR .
                $imageName;


            file_put_contents(
                $targetPath,
                file_get_contents(
                    $image->getRealPath()
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN BUKU
        |--------------------------------------------------------------------------
        */

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'category' => $request->category,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imageName,
        ]);


        return redirect('/admin/books')
            ->with(
                'success',
                'Buku berhasil ditambahkan!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL BUKU
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $book = Book::findOrFail($id);

        return view(
            'books.show',
            compact('book')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT BUKU
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $book = Book::findOrFail($id);

        return view(
            'books.edit',
            compact('book')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE BUKU
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    ) {

        $book = Book::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);


        /*
        |--------------------------------------------------------------------------
        | DATA BUKU
        |--------------------------------------------------------------------------
        */

        $book->title =
            $request->title;

        $book->author =
            $request->author;

        $book->category =
            $request->category;

        $book->description =
            $request->description;

        $book->price =
            $request->price;

        $book->stock =
            $request->stock;


        /*
        |--------------------------------------------------------------------------
        | UPDATE FOTO
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            /*
            | Hapus foto lama
            */

            if (
                !empty($book->image) &&
                file_exists(
                    public_path(
                        'img/' . $book->image
                    )
                )
            ) {

                unlink(
                    public_path(
                        'img/' . $book->image
                    )
                );
            }


            /*
            | Upload foto baru
            */

            $image =
                $request->file('image');


            $destination =
                public_path('img');


            if (!is_dir($destination)) {

                mkdir(
                    $destination,
                    0777,
                    true
                );
            }


            $originalName =
                $image->getClientOriginalName();


            $cleanName = preg_replace(
                '/[^A-Za-z0-9._-]/',
                '_',
                $originalName
            );


            $imageName =
                time() . '_' . $cleanName;


            $targetPath =
                $destination .
                DIRECTORY_SEPARATOR .
                $imageName;


            file_put_contents(
                $targetPath,
                file_get_contents(
                    $image->getRealPath()
                )
            );


            $book->image =
                $imageName;
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN
        |--------------------------------------------------------------------------
        */

        $book->save();


        return redirect('/admin/books')
            ->with(
                'success',
                'Buku berhasil diperbarui!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS BUKU
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $book =
            Book::findOrFail($id);


        if (
            !empty($book->image) &&
            file_exists(
                public_path(
                    'img/' . $book->image
                )
            )
        ) {

            unlink(
                public_path(
                    'img/' . $book->image
                )
            );
        }


        $book->delete();


        return redirect('/admin/books')
            ->with(
                'success',
                'Buku berhasil dihapus!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | CATEGORY
    |--------------------------------------------------------------------------
    */

    public function category($category)
    {
        $allowedCategories = [
            'Pendidikan',
            'Self Improvement',
            'Sains',
            'Novel',
            'Psikologi',
            'Bisnis & Keuangan',
            'Sejarah & Geografi',
            'Agama & Spiritual',
            'Teknologi & Komputer',
            'Lainnya',
        ];


        if (
            !in_array(
                $category,
                $allowedCategories
            )
        ) {

            abort(404);
        }


        $books = Book::where(
            'category',
            $category
        )
            ->orderBy(
                'id',
                'desc'
            )
            ->get();


        return view(
            'books.category',
            compact(
                'books',
                'category'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CART
    |--------------------------------------------------------------------------
    */

    public function cart()
    {
        $cart =
            session()->get(
                'cart',
                []
            );


        if (!is_array($cart)) {
            $cart = [];
        }


        $total = 0;


        foreach ($cart as $item) {

            if (!is_array($item)) {
                continue;
            }


            $price =
                (float) (
                    $item['price'] ?? 0
                );


            $quantity =
                (int) (
                    $item['quantity'] ?? 0
                );


            $total +=
                $price * $quantity;
        }


        return view(
            'books.cart',
            compact(
                'cart',
                'total'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TAMBAH CART
    |--------------------------------------------------------------------------
    */

    public function addToCart($id)
    {
        $book =
            Book::findOrFail($id);


        if ($book->stock <= 0) {

            return back()
                ->with(
                    'success',
                    'Stok buku sedang habis!'
                );
        }


        $cart =
            session()->get(
                'cart',
                []
            );


        if (!is_array($cart)) {
            $cart = [];
        }


        if (
            isset($cart[$id]) &&
            is_array($cart[$id])
        ) {

            $currentQuantity =
                (int) (
                    $cart[$id]['quantity'] ?? 0
                );


            if (
                $currentQuantity >=
                (int) $book->stock
            ) {

                return back()
                    ->with(
                        'success',
                        'Jumlah buku melebihi stok!'
                    );
            }


            $cart[$id]['quantity'] =
                $currentQuantity + 1;

        } else {

            $cart[$id] = [
                'title' =>
                    $book->title,

                'author' =>
                    $book->author,

                'price' =>
                    $book->price,

                'image' =>
                    $book->image,

                'quantity' => 1,
            ];
        }


        session()->put(
            'cart',
            $cart
        );


        return redirect('/cart')
            ->with(
                'success',
                'Buku masuk ke keranjang!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS CART
    |--------------------------------------------------------------------------
    */

    public function removeFromCart($id)
    {
        $cart =
            session()->get(
                'cart',
                []
            );


        if (!is_array($cart)) {
            $cart = [];
        }


        if (isset($cart[$id])) {

            unset(
                $cart[$id]
            );
        }


        session()->put(
            'cart',
            $cart
        );


        return redirect('/cart')
            ->with(
                'success',
                'Buku dihapus dari keranjang!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | CHECKOUT
    |--------------------------------------------------------------------------
    */

    public function checkout()
    {
        $cart =
            session()->get(
                'cart',
                []
            );


        if (!is_array($cart)) {
            $cart = [];
        }


        if (empty($cart)) {

            return redirect('/')
                ->with(
                    'success',
                    'Keranjang masih kosong!'
                );
        }


        $total = 0;


        foreach ($cart as $item) {

            if (!is_array($item)) {
                continue;
            }


            $price =
                (float) (
                    $item['price'] ?? 0
                );


            $quantity =
                (int) (
                    $item['quantity'] ?? 0
                );


            $total +=
                $price * $quantity;
        }


        return view(
            'books.checkout',
            compact(
                'cart',
                'total'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PAYMENT SUCCESS
    |--------------------------------------------------------------------------
    */

    public function paymentSuccess()
    {
        session()->forget(
            'cart'
        );


        return redirect('/')
            ->with(
                'success',
                'Pembayaran berhasil dikonfirmasi!'
            );
    }
}