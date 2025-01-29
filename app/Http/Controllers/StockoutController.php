<?php

namespace App\Http\Controllers;

use App\Models\Stockout;
use Illuminate\Http\Request;

class StockoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $stockouts = Stockout::with(['product', 'user'])->get();
            return datatables()->of($stockouts)
                ->addColumn('product_name', function($row) {
                    return $row->product->name;
                })
                ->addColumn('user_name', function($row) {
                    return $row->user->name;
                })
                ->make(true);
        }

        return view('stockout.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
