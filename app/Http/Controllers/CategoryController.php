<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Crypt;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('cari');

        $categories = Category::when($keyword, function ($query, $keyword) {
            return $query->where('name', 'LIKE', "%$keyword%");
        })->paginate(10);

        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:categories,code',
        ]);

        Category::create($request->only('name', 'code'));

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show($id)
    {
        $category = Category::findOrFail(Crypt::decrypt($id));
        return view('admin.categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail(Crypt::decrypt($id));
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail(Crypt::decrypt($id));

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:categories,code,' . $category->id,
        ]);

        $category->update($request->only('name', 'code'));

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail(Crypt::decrypt($id));
        $category->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
