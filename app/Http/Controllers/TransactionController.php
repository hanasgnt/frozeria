<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('item.category')->latest();

        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_until')) {
            $query->whereDate('created_at', '<=', $request->date_until);
        }

        $transactions = $query->paginate(20)->withQueryString();
        $items = Item::orderBy('name')->get();

        return view('transaction.index', compact('transactions', 'items'));
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

        return redirect()->route('item.show', $item)
            ->with('success', "Stok berhasil diperbarui. {$stockBefore} → {$stockAfter} {$item->unit}.");
    }

    public function history(Item $item)
    {
        $transactions = $item->transactions()->paginate(15);
        return view('transaction.history', compact('item', 'transactions'));
    }
}