<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PerawatController extends Controller
{
    public function index()
    {
        $perawats = User::where('role', 'perawat')->paginate(10);
        return view('admin.perawat.index', compact('perawats'));
    }

    public function create()
    {
        return view('admin.perawat.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:3',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'perawat',
        ]);

        return redirect()->route('admin.perawat.index')
            ->with('success', 'Perawat berhasil ditambahkan');
    }

    public function show(User $perawat)
    {
        $this->cekPerawat($perawat);
        return view('admin.perawat.show', compact('perawat'));
    }

    public function edit(User $perawat)
    {
        $this->cekPerawat($perawat);
        return view('admin.perawat.edit', compact('perawat'));
    }

    public function update(Request $request, User $perawat)
    {
        $this->cekPerawat($perawat);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $perawat->id,
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $perawat->update($data);

        return redirect()->route('admin.perawat.index')
            ->with('success', 'Perawat berhasil diupdate');
    }

    
}
