<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $items = $query->paginate(15)->withQueryString();
        $categories = Category::all();

        $totalItems = Item::count();
        $totalCategories = Category::count();
        $lowStock = Item::whereRaw('stock <= minimum_stock AND stock > 0')->count();
        $stokMenipis = Item::where('stock', '>', 0)->where('stock', '<', 20)->count();
        $stokHabis = Item::where('stock', 0)->count();

        return view('dashboard.index', compact('items', 'categories', 'totalItems', 'totalCategories', 'lowStock', 'stokMenipis', 'stokHabis'));
    }

    public function show(Item $item)
    {
        $item->load('category');
        return view('item.show', compact('item'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('item.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'minimum_stock' => 'nullable|integer|min:0',
            'unit' => 'required|string|max:50',
            'selling_price' => 'nullable|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'weight' => 'nullable|string|max:100',
            'storage_location' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('items', 'public');
        }

        Item::create($data);

        return redirect()->route('dashboard')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit(Item $item)
    {
        $categories = Category::all();
        return view('item.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'minimum_stock' => 'nullable|integer|min:0',
            'unit' => 'required|string|max:50',
            'selling_price' => 'nullable|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'weight' => 'nullable|string|max:100',
            'storage_location' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except(['photo', '_method', '_token']);

        if ($request->hasFile('photo')) {
            if ($item->photo) {
                Storage::disk('public')->delete($item->photo);
            }
            $data['photo'] = $request->file('photo')->store('items', 'public');
        }

        $item->update($data);

        return redirect()->route('dashboard')->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy(Item $item)
    {
        if ($item->photo) {
            Storage::disk('public')->delete($item->photo);
        }
        $item->delete();

        return redirect()->route('dashboard')->with('success', 'Barang berhasil dihapus!');
    }
}