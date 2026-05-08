<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasienController extends Controller
{
  public function index(Request $request)
  {
    // Memulai query dengan relasi pengguna, dan KUNCI HANYA UNTUK ROLE 'pasien'
    $query = Pasien::with('pengguna')->whereHas('pengguna', function ($q) {
      $q->where('role', 'pasien');
    });

    // Jika ada input pencarian
    if ($request->has('search') && $request->search != '') {
      $search = $request->search;

      // Cari berdasarkan relasi nama di tabel users
      $query->whereHas('pengguna', function ($q) use ($search) {
        $q->where('name', 'like', '%' . $search . '%');
      });
    }

    // Mengambil data dengan pagination (misal 10 data per halaman) dan urutan terbaru
    $pasiens = $query->latest()->paginate(10);

    return view('admin.pasien.index', compact('pasiens'));
  }

  public function show(Pasien $pasien)
  {
    return view('admin.pasien.show', compact('pasien'));
  }

  public function create()
  {
    return view('admin.pasien.create');
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'nik' => 'required|string|unique:pasiens,nik',
      'alamat' => 'required|string',
      'no_hp' => 'required|string',
      'tanggal_lahir' => 'required|date',
    ]);

    $user = User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make('secret'),
      'role' => 'pasien',
    ]);

    Pasien::create([
      'pengguna_id' => $user->id,
      'nik' => $data['nik'],
      'alamat' => $data['alamat'],
      'no_hp' => $data['no_hp'],
      'tanggal_lahir' => $data['tanggal_lahir'],
    ]);

    return redirect()->route('admin.pasien.index')->with('success', 'Pasien berhasil dibuat.');
  }

  public function edit(Pasien $pasien)
  {
    $pengguna = $pasien->pengguna;
    return view('admin.pasien.edit', compact('pasien', 'pengguna'));
  }

  public function update(Request $request, Pasien $pasien)
  {
    $data = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email,' . ($pasien->pengguna_id ?? 'NULL'),
      'nik' => 'required|string|unique:pasiens,nik,' . $pasien->id,
      'alamat' => 'required|string',
      'no_hp' => 'required|string',
      'tanggal_lahir' => 'required|date',
    ]);

    // update user
    if ($pasien->pengguna) {
      $pasien->pengguna->update([
        'name' => $data['name'],
        'email' => $data['email'],
      ]);
    }

    // update pasien
    $pasien->update([
      'nik' => $data['nik'],
      'alamat' => $data['alamat'],
      'no_hp' => $data['no_hp'],
      'tanggal_lahir' => $data['tanggal_lahir'],
    ]);

    return redirect()->route('admin.pasien.index')->with('success', 'Pasien berhasil diperbarui.');
  }

  public function destroy(Pasien $pasien)
  {
    $userId = $pasien->pengguna_id;
    $pasien->delete();
    return redirect()->route('admin.pasien.index')->with('success', 'Pasien berhasil dihapus.');
  }
}
