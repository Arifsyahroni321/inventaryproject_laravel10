<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kt = User::orderBy('created_at', 'desc')->paginate(10);
        return view('user.index', compact('kt'));
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
            $request->validate([
                'id_user' => 'required|int|unique:users,id_user',
                'name' => 'required|string',
                'username' => 'required|string',
                'password' => 'required|string|min:6',
                'email' => 'required|email|unique:users,email',
                'role' => 'required|in:admin,petugas,pegawai',
            ], [
                'id_user.unique' => 'ID user sudah digunakan, silakan gunakan ID lain.',
                'id_user.required' => 'ID user wajib diisi.',
                'id_user.int' => 'ID user harus berupa angka.',
                'name.required' => 'Nama user wajib diisi.',
                'username.required' => 'Nama username wajib diisi.',
                'password.required' => 'Nama password wajib diisi.',
                'email.required' => 'Nama email wajib diisi.',
                'email.unique' => 'Nama email sudah digunakan.',
                'role.required' => 'role wajib di isi.',
            ]);

            User::create([
                'id_user' => $request->id_user,
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'role' => $request->role,
            ]);

            return redirect()->route('user.index')->with('success', 'user created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('user.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
        $category = User::findOrFail($id); // Cari kategori berdasarkan ID
        return response()->json($category);
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
