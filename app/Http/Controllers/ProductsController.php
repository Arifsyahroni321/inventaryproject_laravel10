<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Category;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all(); // Ambil semua kategori dari database
        return view('product.index', compact('categories'));
    }
    public function getData()
    {
        $products = Product::with('category')
            ->select('id_product', 'name', 'categori_id', 'desc', 'price', 'stock_quantity', 'minimum_stock_level', 'created_at', 'updated_at');

        return DataTables::of($products)
            ->addColumn('category', function ($row) {
                return $row->category ? $row->category->name : 'Uncategorized';
            })
            ->addColumn('action', function ($row) {
                return '
               <div class="btn-group" role="group" aria-label="Aksi">
                <button data-id="' . $row->id_product . '" class="btn btn-sm btn-warning btn-edit"><i class="bi-pen-fill"></i></button>
               <a href="/product/' . $row->id_product . '" class="btn btn-sm btn-info " title="Lihat"><i class="bi-eye-fill"></i></a>
                    <form action="' . route('product.destroy', $row->id_product) . '" method="POST" class="delete-form" >
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger delete-button" title="Hapus"><i class="bi-trash-fill"></i></button>
                    </form>
                </div>
            ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'id_product' => 'required|unique:products,id_product|string|max:50',
                'name' => 'required|string|max:255',
                'categori_id' => 'required|exists:categories,id_categori',
                'desc' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
                'minimum_stock_level' => 'required|integer|min:0',
            ], [
                'id_product.required' => 'ID Product harus diisi.',
                'id_product.unique' => 'ID Produk sudah digunakan.',
                'name.required' => 'Nama produk harus diisi.',
                'categori_id.required' => 'Kategori harus dipilih.',
                'price.required' => 'Harga produk harus diisi.',
                'stock_quantity.required' => 'Stok produk harus diisi.',
                'minimum_stock_level.required' => 'Minimum stok harus diisi.',
            ]);

            // Simpan data ke database
            $product = new Product();
            $product->id_product = $validated['id_product'];
            $product->name = $validated['name'];
            $product->categori_id = $validated['categori_id'];
            $product->desc = $validated['desc'];
            $product->price = $validated['price'];
            $product->stock_quantity = $validated['stock_quantity'];
            $product->minimum_stock_level = $validated['minimum_stock_level'];
            $product->save();

            return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('product.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('category')->findOrFail($id);
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::with('category')->find($id);
    if (!$product) {
        return response()->json(['error' => 'Produk tidak ditemukan'], 404);
    }
    return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Validasi data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'categori_id' => 'required|exists:categories,id_categori',
                'desc' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
                'minimum_stock_level' => 'required|integer|min:0',
            ], [
                'name.required' => 'Nama produk harus diisi.',
                'categori_id.required' => 'Kategori harus dipilih.',
                'price.required' => 'Harga produk harus diisi.',
                'stock_quantity.required' => 'Stok produk harus diisi.',
                'minimum_stock_level.required' => 'Minimum stok harus diisi.',
            ]);

            // Cari produk berdasarkan ID
            $product = Product::findOrFail($id);

            // Update data produk
            $product->update([
                'name' => $validated['name'],
                'categori_id' => $validated['categori_id'],
                'desc' => $validated['desc'],
                'price' => $validated['price'],
                'stock_quantity' => $validated['stock_quantity'],
                'minimum_stock_level' => $validated['minimum_stock_level'],
            ]);

            return response()->json(['success' => 'Produk berhasil diperbarui']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return redirect()->route('product.index')->with('success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('product.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
