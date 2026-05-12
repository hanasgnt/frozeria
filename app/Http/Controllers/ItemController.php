<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('cid')) {
            if ($request->cid === 'null') {
                $query->whereNull('category_id');
            } elseif ($request->cid != '') {
                $query->where('category_id', $request->cid);
            }
        }

        $perPage = $request->get('per_page', 10);

        $items = $query
            ->paginate($perPage)
            ->withQueryString();

        $categories = Category::all();

        $totalItems = DB::select("SELECT COUNT(*) as total FROM items")[0]->total;
        $totalCategories = DB::select("SELECT COUNT(*) as total FROM categories")[0]->total;
        $lowStock = DB::select("SELECT COUNT(*) as total FROM items WHERE stock <= minimum_stock AND stock > 0")[0]->total;
        $stokMenipis = DB::select("SELECT COUNT(*) as total FROM items WHERE stock > 0 AND stock < 20")[0]->total;
        $stokHabis = DB::select("SELECT COUNT(*) as total FROM items WHERE stock = 0")[0]->total;

        return view('dashboard.index', compact(
            'items',
            'categories',
            'totalItems',
            'totalCategories',
            'lowStock',
            'stokMenipis',
            'stokHabis'
        ));
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
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'nullable|exists:categories,id',
                'stock' => 'required|integer|min:0',
                'minimum_stock' => 'nullable|integer|min:20',
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
        } catch (\Exception $e) {
            Log::error('Error store item: ' . $e->getMessage());

            return back()->with('error', 'Gagal menambahkan barang');
        }
    }

    public function edit(Item $item)
    {
        $categories = Category::all();
        return view('item.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'nullable|exists:categories,id',
                'stock' => 'required|integer|min:0',
                'minimum_stock' => 'nullable|integer|min:20',
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

            return redirect()->route('dashboard')
                ->with('success', 'Barang berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error update item: ' . $e->getMessage());

            return back()->with('error', 'Gagal update barang');
        }
    }

    public function destroy(Item $item)
    {
        try {
            if ($item->photo) {
                Storage::disk('public')->delete($item->photo);
            }
            $item->delete();
            return redirect()->route('dashboard')->with('success', 'Barang berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error delete item: ' . $e->getMessage());
            return back()->with('error', 'Gagal hapus barang');
        }
    }
}
