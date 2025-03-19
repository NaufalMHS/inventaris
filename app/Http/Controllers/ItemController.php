<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Building;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('cari');

        $items = Item::with(['category', 'building', 'room'])
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'LIKE', "%$keyword%");
            })
            ->paginate(10);
    
        return view('admin.barang.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::all();
        $buildings = Building::with('rooms')->get(); // Load rooms sekaligus
        return view('admin.barang.create', compact('categories', 'buildings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'building_id' => 'required|exists:buildings,id',
            'room_id' => 'required|exists:rooms,id',
            'status' => 'required|string|in:baru,bekas,rusak',
        ]);

        $category = Category::findOrFail($request->category_id);
        $code = Item::generateItemCode($category);  // Panggil metode statis ini

        Item::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'building_id' => $request->building_id,
            'room_id' => $request->room_id,
            'status' => $request->status,
            'code' => $code,  // Sertakan kode yang sudah di-generate
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $id = Crypt::decrypt($id); // Mendekripsi ID yang terenkripsi
        $item = Item::findOrFail($id); // Mencari barang berdasarkan ID
        $categories = Category::all(); // Mengambil semua kategori barang
        $buildings = Building::with('rooms')->get(); // Mengambil gedung beserta ruangan-ruangannya
        
        return view('admin.barang.edit', compact('item', 'categories', 'buildings'));
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id); // Mendekripsi ID yang terenkripsi
        $item = Item::findOrFail($id); // Mencari barang berdasarkan ID

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'building_id' => 'required|exists:buildings,id',
            'room_id' => 'required|exists:rooms,id',
            'status' => 'required|string|in:baru,bekas,rusak',
        ]);

        // Update data barang
        $item->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'building_id' => $request->building_id,
            'room_id' => $request->room_id,
            'status' => $request->status,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $item = Item::with(['category', 'building', 'room'])->findOrFail($id);
        
        return view('admin.barang.detail', compact('item'));
    }
    
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }

    public function dashboardStatistics()
    {
        $totalItems = Item::count();

        $categories = Category::withCount('items')->get();

        return view('admin.index', compact('totalItems', 'categories'));
    }

    
}
