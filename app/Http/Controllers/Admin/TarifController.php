<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tarif;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    public function index()
    {
        $tarifs = Tarif::latest()->get();
        return view('admin.tarif.index', compact('tarifs'));
    }

    public function create()
    {
        return view('admin.tarif.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tindakan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        Tarif::create([
            'nama_tindakan' => $request->nama_tindakan,
            'harga' => (int) $request->harga,
        ]);

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif baru berhasil ditambahkan.');
    }

    public function edit(Tarif $tarif)
    {
        return view('admin.tarif.edit', compact('tarif'));
    }

    public function update(Request $request, Tarif $tarif)
    {
        $request->validate([
            'nama_tindakan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        $tarif->update([
            'nama_tindakan' => $request->nama_tindakan,
            'harga' => (int) $request->harga,
        ]);

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil diperbarui.');
    }

    public function destroy(Tarif $tarif)
    {
        $tarif->delete();

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil dihapus.');
    }
}
