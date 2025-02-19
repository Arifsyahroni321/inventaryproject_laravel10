<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stockout;
use App\Models\User;
use Illuminate\Http\Request;

class StockoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all(); // Ambil semua produk
        $users = User::all(); // Ambil semua user
        if (request()->ajax()) {
            $stockouts = Stockout::with(['product', 'user'])->get();
            return datatables()->of($stockouts)
                ->addColumn('product_name', function($row) {
                    return $row->product->name;
                })
                ->addColumn('user_name', function($row) {
                    return $row->user->name;
                })
                ->addColumn('action', function ($row) {
                    return '
                   <div class="btn-group" role="group" aria-label="Aksi">
                    <button data-id="' . $row->id_stockout . '" class="btn btn-sm btn-warning btn-edit"><i class="bi-pen-fill"></i></button>
                   <a href="/stockout/' . $row->id_stockout . '" class="btn btn-sm btn-info " title="Lihat"><i class="bi-eye-fill"></i></a>
                        <form action="' . route('stockout.destroy', $row->id_stockout) . '" method="POST" class="delete-form" >
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

        return view('stockout.index',compact('products','users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([

                'product_id' => 'required|exists:products,id_product',
                'quantity' => 'required|integer|min:0',
                'date' => 'required|date',
                'description' => 'required|string',
                'removed_by' => 'required|exists:users,id_user',

            ], [
                // 'id_stockout.required' => 'ID stock harus diisi.',
                // 'id_stockout.unique' => 'ID stock sudah ada.',
                'product_id.required' => 'ID produk harus diisi.',
                'product_id.exists' => 'Produk tidak ditemukan.',
                'quantity.required' => 'Jumlah harus diisi.',
                'date.required' => 'Tanggal harus diisi.',
                'removed_by.required' => 'removed harus diisi.',
                'description.required' => 'description harus diisi.',
                'removed_by.exists' => 'removed fiel tidak ditemukan.',

            ]);

            // Simpan data ke database
            Stockout::create([
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'date' => $validated['date'],
                'description' => $validated['description'],
                'removed_by' => $validated['removed_by'],
            ]);

            return redirect()->route('stockout.index')->with('success', 'Stockout berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('stockout.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $stockout = Stockout::with(['product', 'user'])->find($id);
        return response()->json($stockout);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $stockout = Stockout::with(['product', 'user'])->find($id);

        if (!$stockout) {
            return response()->json([
                'status' => 'error',
                'message' => 'Stockout not found'
            ], 404);

        }

        return response()->json($stockout);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id_product',
                'quantity' => 'required|integer|min:0',
                'date' => 'required|date',
                'description' => 'required|string',
                'removed_by' => 'required|exists:users,id_user',
            ], [
                'product_id.required' => 'ID produk harus diisi.',
                'product_id.exists' => 'Produk tidak ditemukan.',
                'quantity.required' => 'Jumlah harus diisi.',
                'date.required' => 'Tanggal harus diisi.',
                'removed_by.required' => 'removed harus diisi.',
                'description.required' => 'description harus diisi.',
                'removed_by.exists' => 'removed fiel tidak ditemukan.',
            ]);
            $stockout = Stockout::findorFail($id);
            $stockout->update([
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'date' => $validated['date'],
                'description' => $validated['description'],
                'removed_by' => $validated['removed_by'],
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Stockout updated successfully'
            ]);
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
            $product = Stockout::findOrFail($id);
            $product->delete();

            return redirect()->route('stockout.index')->with('success', 'Stockout berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('stockout.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
