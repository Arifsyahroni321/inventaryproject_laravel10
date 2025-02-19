<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stockin;
use App\Models\User;
use Illuminate\Http\Request;

class StockinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $users = User::all();
        if (request()->ajax()) {
            $stockin = Stockin::with(['product', 'user'])->get();
            return datatables()->of($stockin)
                ->addColumn('product_name', function($row) {
                    return $row->product->name;
                })
                ->addColumn('user_name', function($row) {
                    return $row->user->name;
                })
                ->addColumn('action', function ($row) {
                    return '
                   <div class="btn-group" role="group" aria-label="Aksi">
                    <button data-id="' . $row->id_stockin . '" class="btn btn-sm btn-warning btn-edit"><i class="bi-pen-fill"></i></button>
                   <a href="/stockin/' . $row->id_stockin . '" class="btn btn-sm btn-info " title="Lihat"><i class="bi-eye-fill"></i></a>
                        <form action="' . route('stockin.destroy', $row->id_stockin) . '" method="POST" class="delete-form" >
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
        return view('stockin.index',compact('products','users'));

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
                'description' => 'required|string',
                'added_by' => 'required|exists:users,id_user',

            ], [
                // 'id_stockout.required' => 'ID stock harus diisi.',
                // 'id_stockout.unique' => 'ID stock sudah ada.',
                'product_id.required' => 'ID produk harus diisi.',
                'product_id.exists' => 'Produk tidak ditemukan.',
                'quantity.required' => 'Jumlah harus diisi.',
                'added_by.required' => 'removed harus diisi.',
                'description.required' => 'description harus diisi.',
                'added_by.exists' => 'removed fiel tidak ditemukan.',

            ]);

            // Simpan data ke database
            Stockin::create([
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'description' => $validated['description'],
                'added_by' => $validated['added_by'],
            ]);

            return redirect()->route('stockin.index')->with('success', 'stockin berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('stockin.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
