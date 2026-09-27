<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Book;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminExpenseController;


/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', [BookController::class, 'index'])
    ->name('home');


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', function (Request $request) {

    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {

        $request->session()->regenerate();

        if (Auth::user()->is_admin) {
            return redirect('/')
                ->with('success', 'Login sebagai Admin berhasil!');
        }

        return redirect('/')
            ->with('success', 'Login berhasil! Selamat datang.');
    }

    return back()
        ->withErrors([
            'email' => 'Email atau password salah.',
        ])
        ->withInput(
            $request->only('email')
        );

})->name('login.process')
  ->withoutMiddleware([
      \App\Http\Middleware\VerifyCsrfToken::class
  ]);


/*
|--------------------------------------------------------------------------
| REGISTER
|--------------------------------------------------------------------------
*/

Route::get('/register', function () {
    return view('auth.register');
})->name('register');


Route::post('/register', function (Request $request) {

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'is_admin' => false,
    ]);

    return redirect('/login')
        ->with(
            'success',
            'Registrasi berhasil! Silakan login.'
        );

})->withoutMiddleware([
    \App\Http\Middleware\VerifyCsrfToken::class
]);


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| BOOKS - USER
|--------------------------------------------------------------------------
*/

Route::get('/books/create', [BookController::class, 'create'])
    ->name('books.create');

Route::post('/books', [BookController::class, 'store'])
    ->name('books.store');

Route::get('/books/{id}/edit', [BookController::class, 'edit'])
    ->name('books.edit');

Route::put('/books/{id}', [BookController::class, 'update'])
    ->name('books.update');

Route::delete('/books/{id}', [BookController::class, 'destroy'])
    ->name('books.destroy');

Route::get('/books/{id}', [BookController::class, 'show'])
    ->name('books.show');


/*
|--------------------------------------------------------------------------
| CATEGORY
|--------------------------------------------------------------------------
*/

Route::get(
    '/category/{category}',
    [BookController::class, 'category']
)->name('books.category');


/*
|--------------------------------------------------------------------------
| CART
|--------------------------------------------------------------------------
*/

Route::get(
    '/cart',
    [BookController::class, 'cart']
)->name('cart');

Route::match(
    ['GET', 'POST'],
    '/cart/add/{id}',
    [BookController::class, 'addToCart']
)->name('cart.add');

Route::match(
    ['GET', 'POST'],
    '/cart/remove/{id}',
    [BookController::class, 'removeFromCart']
)->name('cart.remove');


/*
|--------------------------------------------------------------------------
| CHECKOUT - HALAMAN
|--------------------------------------------------------------------------
*/

Route::get('/checkout', function () {

    if (!Auth::check()) {
        return redirect('/login');
    }

    $cart = session()->get('cart', []);

    if (!is_array($cart)) {
        $cart = [];
    }

    if (empty($cart)) {
        return redirect('/cart')
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

        $price = (float) ($item['price'] ?? 0);
        $quantity = (int) ($item['quantity'] ?? 0);

        $total += $price * $quantity;
    }

    return view(
        'books.checkout',
        compact(
            'cart',
            'total'
        )
    );

})->name('checkout');


/*
|--------------------------------------------------------------------------
| CHECKOUT - PROSES
|--------------------------------------------------------------------------
*/

Route::post('/checkout', function (Request $request) {

    if (!Auth::check()) {
        return redirect('/login');
    }

    $request->validate([
        'customer_name' => 'required|string|max:255',
        'phone' => 'required|string|max:30',
        'address' => 'required|string|max:1000',
        'payment_method' => 'required|string|max:50',
    ]);

    $cart = session()->get('cart', []);

    if (!is_array($cart) || empty($cart)) {
        return redirect('/cart')
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

        $price = (float) ($item['price'] ?? 0);
        $quantity = (int) ($item['quantity'] ?? 0);

        $total += $price * $quantity;
    }


    /*
    |--------------------------------------------------------------------------
    | BUAT ORDER
    |--------------------------------------------------------------------------
    */

    $orderId = DB::table('orders')->insertGetId([
        'user_id' => Auth::id(),
        'total' => $total,
        'status' => 'pending',
        'payment_method' => $request->payment_method,
        'created_at' => now(),
    ]);


    /*
    |--------------------------------------------------------------------------
    | SIMPAN ITEM ORDER
    |--------------------------------------------------------------------------
    */

    foreach ($cart as $bookId => $item) {

        if (!is_array($item)) {
            continue;
        }

        $quantity = (int) ($item['quantity'] ?? 0);
        $price = (float) ($item['price'] ?? 0);

        $subtotal = $quantity * $price;


        DB::table('order_items')->insert([
            'order_id' => $orderId,
            'book_id' => $bookId,
            'qty' => $quantity,
            'price' => $price,
            'subtotal' => $subtotal,
        ]);


        /*
        |--------------------------------------------------------------------------
        | KURANGI STOK
        |--------------------------------------------------------------------------
        */

        $book = Book::find($bookId);

        if ($book) {

            $book->stock = max(
                0,
                (int) $book->stock - $quantity
            );

            $book->save();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | KE NOTA
    |--------------------------------------------------------------------------
    */

    return redirect(
        '/orders/' . $orderId . '/nota'
    );

})->name('checkout.process')
  ->withoutMiddleware([
      \App\Http\Middleware\VerifyCsrfToken::class
  ]);


/*
|--------------------------------------------------------------------------
| NOTA
|--------------------------------------------------------------------------
*/

Route::get('/orders/{orderId}/nota', function ($orderId) {

    if (!Auth::check()) {
        return redirect('/login');
    }

    $order = DB::table('orders')
        ->where('id', $orderId)
        ->where('user_id', Auth::id())
        ->first();

    if (!$order) {
        abort(404);
    }

    $items = DB::table('order_items')
        ->leftJoin(
            'books',
            'order_items.book_id',
            '=',
            'books.id'
        )
        ->where(
            'order_items.order_id',
            $orderId
        )
        ->select(
            'order_items.id',
            'order_items.order_id',
            'order_items.book_id',
            'order_items.qty',
            'order_items.price',
            'order_items.subtotal',
            'books.title as book_title'
        )
        ->get();

    return view(
        'orders.nota',
        compact(
            'order',
            'items'
        )
    );

})->name('orders.nota');


/*
|--------------------------------------------------------------------------
| PAYMENT
|--------------------------------------------------------------------------
*/

Route::get('/payment/{orderId}', function ($orderId) {

    if (!Auth::check()) {
        return redirect('/login');
    }

    $order = DB::table('orders')
        ->where('id', $orderId)
        ->where('user_id', Auth::id())
        ->first();

    if (!$order) {
        abort(404);
    }

    return view(
        'books.payment',
        compact('order')
    );

})->name('payment');


Route::post('/payment/{orderId}/confirm', function ($orderId) {

    if (!Auth::check()) {
        return redirect('/login');
    }

    $order = DB::table('orders')
        ->where('id', $orderId)
        ->where('user_id', Auth::id())
        ->first();

    if (!$order) {
        abort(404);
    }

    DB::table('orders')
        ->where('id', $orderId)
        ->update([
            'status' => 'paid',
            'updated_at' => now(),
        ]);

    session()->forget('cart');

    return redirect('/orders')
        ->with(
            'success',
            'Pembayaran berhasil dikonfirmasi!'
        );

})->name('payment.confirm')
  ->withoutMiddleware([
      \App\Http\Middleware\VerifyCsrfToken::class
  ]);


/*
|--------------------------------------------------------------------------
| PESANAN SAYA
|--------------------------------------------------------------------------
*/

Route::get('/orders', function () {

    if (!Auth::check()) {
        return redirect('/login');
    }

    $orders = DB::table('orders')
        ->where(
            'user_id',
            Auth::id()
        )
        ->orderBy(
            'id',
            'desc'
        )
        ->get();


    foreach ($orders as $order) {

        $order->items = DB::table('order_items')
            ->leftJoin(
                'books',
                'order_items.book_id',
                '=',
                'books.id'
            )
            ->where(
                'order_items.order_id',
                $order->id
            )
            ->select(
                'order_items.id',
                'order_items.order_id',
                'order_items.book_id',
                'order_items.qty',
                'order_items.price',
                'order_items.subtotal',
                'books.title as book_title',
                'books.image as book_image'
            )
            ->get();


        foreach ($order->items as $item) {

            $item->review = DB::table('reviews')
                ->where(
                    'user_id',
                    Auth::id()
                )
                ->where(
                    'order_id',
                    $order->id
                )
                ->where(
                    'book_id',
                    $item->book_id
                )
                ->first();
        }
    }


    return view(
        'orders.index',
        compact('orders')
    );

})->name('orders');


/*
|--------------------------------------------------------------------------
| REVIEW
|--------------------------------------------------------------------------
*/

Route::post('/reviews', function (Request $request) {

    if (!Auth::check()) {
        return redirect('/login');
    }

    $request->validate([
        'order_id' => 'required|integer',
        'book_id' => 'required|integer',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ]);


    $order = DB::table('orders')
        ->where(
            'id',
            $request->order_id
        )
        ->where(
            'user_id',
            Auth::id()
        )
        ->where(
            'status',
            'completed'
        )
        ->first();


    if (!$order) {

        return back()
            ->withErrors([
                'rating' =>
                    'Pesanan belum selesai atau bukan milik kamu.'
            ]);
    }


    $orderItem = DB::table('order_items')
        ->where(
            'order_id',
            $order->id
        )
        ->where(
            'book_id',
            $request->book_id
        )
        ->first();


    if (!$orderItem) {

        return back()
            ->withErrors([
                'rating' =>
                    'Buku tersebut tidak ada dalam pesanan.'
            ]);
    }


    $alreadyReviewed = DB::table('reviews')
        ->where(
            'user_id',
            Auth::id()
        )
        ->where(
            'order_id',
            $order->id
        )
        ->where(
            'book_id',
            $request->book_id
        )
        ->exists();


    if ($alreadyReviewed) {

        return back()
            ->withErrors([
                'rating' =>
                    'Kamu sudah memberikan rating untuk buku ini.'
            ]);
    }


    DB::table('reviews')->insert([
        'user_id' => Auth::id(),
        'book_id' => $request->book_id,
        'order_id' => $order->id,
        'rating' => $request->rating,
        'comment' => $request->comment,
        'created_at' => now(),
        'updated_at' => now(),
    ]);


    return back()
        ->with(
            'success',
            '⭐ Rating berhasil dikirim!'
        );

})->name('reviews.store')
  ->withoutMiddleware([
      \App\Http\Middleware\VerifyCsrfToken::class
  ]);


/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/admin', function () {

    if (!Auth::check() || !Auth::user()->is_admin) {
        return redirect('/');
    }

    return view(
        'admin.dashboard'
    );

})->name('admin.dashboard');


Route::get('/admin/dashboard', function () {

    if (!Auth::check() || !Auth::user()->is_admin) {
        return redirect('/');
    }

    return redirect('/admin');

});


/*
|--------------------------------------------------------------------------
| ADMIN BOOKS
|--------------------------------------------------------------------------
*/

Route::get('/admin/books', function () {

    if (!Auth::check() || !Auth::user()->is_admin) {
        return redirect('/');
    }

    $books = Book::orderBy(
        'id',
        'desc'
    )->get();

    return view(
        'admin.books.index',
        compact('books')
    );

})->name('admin.books');


/*
|--------------------------------------------------------------------------
| ADMIN TAMBAH BUKU
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/books/create',
    [BookController::class, 'create']
)->name('admin.books.create');


/*
|--------------------------------------------------------------------------
| ADMIN EDIT BUKU
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/books/{id}/edit',
    [BookController::class, 'edit']
)->name('admin.books.edit');


/*
|--------------------------------------------------------------------------
| ADMIN UPDATE BUKU
|--------------------------------------------------------------------------
*/

Route::put(
    '/admin/books/{id}',
    [BookController::class, 'update']
)->name('admin.books.update');


/*
|--------------------------------------------------------------------------
| ADMIN HAPUS BUKU
|--------------------------------------------------------------------------
*/

Route::delete(
    '/admin/books/{id}',
    [BookController::class, 'destroy']
)->name('admin.books.destroy');


/*
|--------------------------------------------------------------------------
| ADMIN USERS
|--------------------------------------------------------------------------
*/

Route::get('/admin/users', function () {

    if (!Auth::check() || !Auth::user()->is_admin) {
        return redirect('/');
    }

    $users = User::orderBy(
        'id',
        'desc'
    )->get();

    return view(
        'admin.users.index',
        compact('users')
    );

})->name('admin.users');


/*
|--------------------------------------------------------------------------
| ADMIN DISCOUNTS
|--------------------------------------------------------------------------
*/

Route::get('/admin/promos', function () {

    if (!Auth::check() || !Auth::user()->is_admin) {
        return redirect('/');
    }

    return view(
        'admin.discounts.index'
    );

})->name('admin.promos');

/*
|--------------------------------------------------------------------------
| ADMIN PAYMENT
|--------------------------------------------------------------------------
*/

Route::get('/admin/payment', function () {

    if (!Auth::check() || !Auth::user()->is_admin) {
        return redirect('/');
    }

    return view(
        'admin.payment.index'
    );

})->name('admin.payment');


/*
|--------------------------------------------------------------------------
| ADMIN KELOLA PESANAN
|--------------------------------------------------------------------------
*/

Route::get('/admin/orders', function () {

    if (!Auth::check() || !Auth::user()->is_admin) {
        return redirect('/');
    }

    return view(
        'admin.orders.index'
    );

})->name('admin.orders');


/*
|--------------------------------------------------------------------------
| ADMIN UBAH STATUS PESANAN
|--------------------------------------------------------------------------
*/

Route::post(
    '/admin/orders/{orderId}/status',
    function (
        Request $request,
        $orderId
    ) {

        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/');
        }


        $request->validate([
            'status' =>
                'required|in:pending,paid,processing,shipped,completed',
        ]);


        $order = DB::table('orders')
            ->where(
                'id',
                $orderId
            )
            ->first();


        if (!$order) {
            abort(404);
        }


        DB::table('orders')
            ->where(
                'id',
                $orderId
            )
            ->update([
                'status' => $request->status,
                'updated_at' => now(),
            ]);


        return back()
            ->with(
                'success',
                'Status pesanan berhasil diperbarui.'
            );

    }
)->name('admin.orders.status')
 ->withoutMiddleware([
     \App\Http\Middleware\VerifyCsrfToken::class
 ]);


/*
|--------------------------------------------------------------------------
| ADMIN REPORTS
|--------------------------------------------------------------------------
*/

Route::get('/admin/reports', function () {

    if (!Auth::check() || !Auth::user()->is_admin) {
        return redirect('/');
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    $paidStatuses = [
        'paid',
        'processing',
        'shipped',
        'completed',
    ];


    /*
    |--------------------------------------------------------------------------
    | REVENUE
    |--------------------------------------------------------------------------
    */

    $todayRevenue = DB::table('orders')
        ->whereIn(
            'status',
            $paidStatuses
        )
        ->whereDate(
            'created_at',
            today()
        )
        ->sum('total');


    $weeklyRevenue = DB::table('orders')
        ->whereIn(
            'status',
            $paidStatuses
        )
        ->whereBetween(
            'created_at',
            [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]
        )
        ->sum('total');


    $monthlyRevenue = DB::table('orders')
        ->whereIn(
            'status',
            $paidStatuses
        )
        ->whereBetween(
            'created_at',
            [
                now()->startOfMonth(),
                now()->endOfMonth()
            ]
        )
        ->sum('total');


    $yearlyRevenue = DB::table('orders')
        ->whereIn(
            'status',
            $paidStatuses
        )
        ->whereYear(
            'created_at',
            now()->year
        )
        ->sum('total');


    /*
    |--------------------------------------------------------------------------
    | EXPENSE
    |--------------------------------------------------------------------------
    */

    $totalExpense = DB::table('expenses')
        ->sum('total');


    $weeklyExpense = DB::table('expenses')
        ->whereBetween(
            'created_at',
            [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]
        )
        ->sum('total');


    $monthlyExpense = DB::table('expenses')
        ->whereBetween(
            'created_at',
            [
                now()->startOfMonth(),
                now()->endOfMonth()
            ]
        )
        ->sum('total');


    $yearlyExpense = DB::table('expenses')
        ->whereYear(
            'created_at',
            now()->year
        )
        ->sum('total');


    /*
    |--------------------------------------------------------------------------
    | NET
    |--------------------------------------------------------------------------
    */

    $weeklyNet =
        $weeklyRevenue -
        $weeklyExpense;


    $monthlyNet =
        $monthlyRevenue -
        $monthlyExpense;


    $yearlyNet =
        $yearlyRevenue -
        $yearlyExpense;


    /*
    |--------------------------------------------------------------------------
    | BOOKS SOLD
    |--------------------------------------------------------------------------
    */

    $weeklyBooksSold = DB::table('order_items')
        ->join(
            'orders',
            'order_items.order_id',
            '=',
            'orders.id'
        )
        ->whereIn(
            'orders.status',
            $paidStatuses
        )
        ->whereBetween(
            'orders.created_at',
            [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]
        )
        ->sum('order_items.qty');


    $monthlyBooksSold = DB::table('order_items')
        ->join(
            'orders',
            'order_items.order_id',
            '=',
            'orders.id'
        )
        ->whereIn(
            'orders.status',
            $paidStatuses
        )
        ->whereBetween(
            'orders.created_at',
            [
                now()->startOfMonth(),
                now()->endOfMonth()
            ]
        )
        ->sum('order_items.qty');


    $yearlyBooksSold = DB::table('order_items')
        ->join(
            'orders',
            'order_items.order_id',
            '=',
            'orders.id'
        )
        ->whereIn(
            'orders.status',
            $paidStatuses
        )
        ->whereYear(
            'orders.created_at',
            now()->year
        )
        ->sum('order_items.qty');


    /*
    |--------------------------------------------------------------------------
    | WEEKLY BOOK SALES
    |--------------------------------------------------------------------------
    */

    $weeklyBookSales = DB::table('order_items')
        ->join(
            'orders',
            'order_items.order_id',
            '=',
            'orders.id'
        )
        ->join(
            'books',
            'order_items.book_id',
            '=',
            'books.id'
        )
        ->whereIn(
            'orders.status',
            $paidStatuses
        )
        ->whereBetween(
            'orders.created_at',
            [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]
        )
        ->select(
            'books.id',
            'books.title',
            DB::raw(
                'SUM(order_items.qty) as total_qty'
            ),
            DB::raw(
                'SUM(order_items.subtotal) as total_sales'
            )
        )
        ->groupBy(
            'books.id',
            'books.title'
        )
        ->orderByDesc(
            'total_qty'
        )
        ->get();


    /*
    |--------------------------------------------------------------------------
    | MONTHLY BOOK SALES
    |--------------------------------------------------------------------------
    */

    $monthlyBookSales = DB::table('order_items')
        ->join(
            'orders',
            'order_items.order_id',
            '=',
            'orders.id'
        )
        ->join(
            'books',
            'order_items.book_id',
            '=',
            'books.id'
        )
        ->whereIn(
            'orders.status',
            $paidStatuses
        )
        ->whereBetween(
            'orders.created_at',
            [
                now()->startOfMonth(),
                now()->endOfMonth()
            ]
        )
        ->select(
            'books.id',
            'books.title',
            DB::raw(
                'SUM(order_items.qty) as total_qty'
            ),
            DB::raw(
                'SUM(order_items.subtotal) as total_sales'
            )
        )
        ->groupBy(
            'books.id',
            'books.title'
        )
        ->orderByDesc(
            'total_qty'
        )
        ->get();


    /*
    |--------------------------------------------------------------------------
    | EXPENSE HISTORY
    |--------------------------------------------------------------------------
    |
    | created_at diberi alias "tanggal"
    | supaya bisa dipanggil sebagai $expense->tanggal
    |
    */

    $expenses = DB::table('expenses')
        ->leftJoin(
            'books',
            'expenses.book_id',
            '=',
            'books.id'
        )
        ->select(
            'expenses.*',
            'expenses.created_at as tanggal',
            'books.title as book_title'
        )
        ->orderByDesc(
            'expenses.created_at'
        )
        ->get();


    /*
    |--------------------------------------------------------------------------
    | RESTOCK BOOKS
    |--------------------------------------------------------------------------
    */

    $restockBooks = Book::where(
        'stock',
        '<=',
        5
    )
        ->orderBy(
            'stock'
        )
        ->get();


    /*
    |--------------------------------------------------------------------------
    | DAILY REVENUE
    |--------------------------------------------------------------------------
    */

    $dailyRevenue = DB::table('orders')
        ->whereIn(
            'status',
            $paidStatuses
        )
        ->whereBetween(
            'created_at',
            [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]
        )
        ->select(
            DB::raw(
                'DATE(created_at) as date'
            ),
            DB::raw(
                'SUM(total) as total'
            )
        )
        ->groupBy(
            DB::raw(
                'DATE(created_at)'
            )
        )
        ->orderBy(
            'date'
        )
        ->get();


    /*
    |--------------------------------------------------------------------------
    | MONTHLY REVENUE CHART
    |--------------------------------------------------------------------------
    */

    $monthlyRevenueChart = DB::table('orders')
        ->whereIn(
            'status',
            $paidStatuses
        )
        ->whereYear(
            'created_at',
            now()->year
        )
        ->select(
            DB::raw(
                'MONTH(created_at) as month'
            ),
            DB::raw(
                'SUM(total) as total'
            )
        )
        ->groupBy(
            DB::raw(
                'MONTH(created_at)'
            )
        )
        ->orderBy(
            'month'
        )
        ->get();


    /*
    |--------------------------------------------------------------------------
    | SYSTEM SUMMARY
    |--------------------------------------------------------------------------
    */

    $bookCount = DB::table('books')
        ->count();


    $totalStock = DB::table('books')
        ->sum('stock');


    $userCount = DB::table('users')
        ->count();


    $orderCount = DB::table('orders')
        ->count();


    $totalRevenue = DB::table('orders')
        ->whereIn(
            'status',
            $paidStatuses
        )
        ->sum('total');


    /*
    |--------------------------------------------------------------------------
    | SEMUA BUKU
    |--------------------------------------------------------------------------
    */

    $books = Book::orderBy(
        'title',
        'asc'
    )->get();


    /*
    |--------------------------------------------------------------------------
    | KIRIM SEMUA DATA KE REPORTS
    |--------------------------------------------------------------------------
    */

    return view(
        'admin.reports.index',
        compact(
            'bookCount',
            'totalStock',
            'userCount',
            'orderCount',
            'totalRevenue',
            'books',
            'todayRevenue',
            'weeklyRevenue',
            'monthlyRevenue',
            'yearlyRevenue',
            'totalExpense',
            'weeklyExpense',
            'monthlyExpense',
            'yearlyExpense',
            'weeklyNet',
            'monthlyNet',
            'yearlyNet',
            'weeklyBooksSold',
            'monthlyBooksSold',
            'yearlyBooksSold',
            'weeklyBookSales',
            'monthlyBookSales',
            'expenses',
            'restockBooks',
            'dailyRevenue',
            'monthlyRevenueChart'
        )
    );

})->name('admin.reports');


/*
|--------------------------------------------------------------------------
| ADMIN EXPENSES / RESTOCK
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/expenses',
    [AdminExpenseController::class, 'index']
)->name('admin.expenses.index');


Route::post(
    '/admin/expenses',
    [AdminExpenseController::class, 'store']
)->name('admin.expenses.store');


Route::delete(
    '/admin/expenses/{id}',
    [AdminExpenseController::class, 'destroy']
)->name('admin.expenses.destroy');


/*
|--------------------------------------------------------------------------
| ACCOUNT USER
|--------------------------------------------------------------------------
*/

Route::get('/account', function () {

    if (!Auth::check()) {
        return redirect('/login');
    }

    if (Auth::user()->is_admin) {
        abort(403);
    }

    return view('account');

})->name('account');