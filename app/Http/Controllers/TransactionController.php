<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('item.category')->latest();

        if (request('q')) {
            $query->where(function ($q) {
                $q->whereHas('item', function ($i) {
                    $i->where('name', 'like', '%' . request('q') . '%');
                })
                    ->orWhere('note', 'like', '%' . request('q') . '%');
            });
        }

        if ($request->filled('item')) {
            $query->where('item_id', $request->item);
        }
        if ($request->filled('t')) {
            $query->where('type', $request->t);
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $transactions = $query->paginate(20)->withQueryString();
        $items = Item::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('transaction.index', compact('transactions', 'items', 'categories'));
    }

    public function create(Item $item)
    {
        return view('transaction.create', compact('item'));
    }

    public function store(Request $request, Item $item)
    {
        $request->validate([
            'type'     => 'required|in:in,out,damaged,return',
            'quantity' => 'required|integer|min:1',
            'note'     => 'nullable|string|max:500',
        ]);

        $stockBefore = $item->stock;

        $isPositive = in_array($request->type, ['in', 'return']);
        $stockAfter = $isPositive
            ? $stockBefore + $request->quantity
            : max(0, $stockBefore - $request->quantity);

        Transaction::create([
            'item_id'      => $item->id,
            'type'         => $request->type,
            'quantity'     => $request->quantity,
            'stock_before' => $stockBefore,
            'stock_after'  => $stockAfter,
            'note'         => $request->note,
        ]);

        $item->update(['stock' => $stockAfter]);

        return redirect()->route('dashboard', $item)
            ->with('success', "Stok berhasil diperbarui. {$stockBefore} → {$stockAfter} {$item->unit}.");
    }

    public function history(Item $item)
    {
        $transactions = $item->transactions()->paginate(15);
        return view('transaction.history', compact('item', 'transactions'));
    }
}
