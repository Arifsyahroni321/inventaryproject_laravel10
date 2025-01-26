<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $kt = Category::orderBy('created_at', 'desc')->paginate(10);
        return view('categori.index', compact('kt'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_categori' => 'required|int|unique:categories,id_categori',
                'name' => 'required|string',
            ], [
                'id_categori.unique' => 'ID Categori sudah digunakan, silakan gunakan ID lain.',
                'id_categori.required' => 'ID Categori wajib diisi.',
                'id_categori.int' => 'ID Categori harus berupa angka.',
                'name.required' => 'Nama kategori wajib diisi.',
            ]);

            Category::create([
                'id_categori' => $request->id_categori,
                'name' => $request->name,
            ]);

            return redirect()->route('categori.index')->with('success', 'categori created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('categori.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $category = Category::findOrFail($id); // Cari kategori berdasarkan ID
        return response()->json($category); // Kirim data dalam format JSON untuk modal
    }

    public function update(Request $request, $id)
    {
        try{
        $request->validate([
            'id_categori' => 'required|int|unique:categories,id_categori,' . $id . ',id_categori',
            'name' => 'required|string',
        ], [
            'id_categori.unique' => 'ID Categori sudah digunakan, silakan gunakan ID lain.',
            'id_categori.required' => 'ID Categori wajib diisi.',
            'name.required' => 'Nama kategori wajib diisi.'
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'id_categori' => $request->id_categori,
            'name' => $request->name,
        ]);

        return redirect()->route('categori.index')->with('success', 'Category updated successfully.');
    } catch (\Exception $e) {
        return redirect()->route('categori.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        // Check if the category is used in any product
        $productCount = Product::where('categori_id', $id)->count();

        if ($productCount > 0) {
            return redirect()->route('categori.index')->with('error', 'category can not delete cause its used in product.!');
        }

        $category->delete();

        return redirect()->route('categori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
