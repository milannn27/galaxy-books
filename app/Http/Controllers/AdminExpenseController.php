<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Expense;
use Illuminate\Http\Request;

class AdminExpenseController extends Controller
{
    public function index()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect('/');
        }

        $books = Book::orderBy('title')->get();

        $expenses = Expense::with('book')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalExpense = Expense::sum('total');

        return view(
            'admin.expenses.index',
            compact(
                'books',
                'expenses',
                'totalExpense'
            )
        );
    }

    public function store(Request $request)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect('/');
        }

        $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
        ]);

        $book = Book::findOrFail($request->book_id);

        $quantity = (int) $request->quantity;

        $unitPrice = (float) $request->unit_price;

        $total = $quantity * $unitPrice;

        $book->stock += $quantity;

        $book->save();

        Expense::create([
            'book_id' => $book->id,
            'description' => $request->description
                ?: 'Restock buku ' . $book->title,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total' => $total,
            'type' => 'restock',
        ]);

        return redirect('/admin/expenses')
            ->with(
                'success',
                'Restock berhasil! Stok buku bertambah dan pengeluaran tercatat.'
            );
    }

    public function destroy($id)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect('/');
        }

        $expense = Expense::findOrFail($id);

        $book = $expense->book;

        if ($book && $expense->type === 'restock') {
            $book->stock = max(
                0,
                $book->stock - $expense->quantity
            );

            $book->save();
        }

        $expense->delete();

        return redirect('/admin/expenses')
            ->with(
                'success',
                'Data pengeluaran berhasil dihapus.'
            );
    }
}