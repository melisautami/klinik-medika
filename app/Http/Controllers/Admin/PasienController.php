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
      $search = trim($request->search);

      // Cari berdasarkan nama pengguna atau NIK pasien
      $query->where(function ($q) use ($search) {
        $q->whereHas('pengguna', function ($userQuery) use ($search) {
          $userQuery->where('name', 'like', '%' . $search . '%');
        })->orWhere('nik', 'like', '%' . $search . '%');
      });
    }

    // Mengambil data dengan pagination (misal 10 data per halaman) dan urutan terbaru
    $pasiens = $query->latest()->paginate(10)->withQueryString();

    return view('admin.pasien.index', compact('pasiens'));
  }

  public function kategori(Request $request, string $kategori)
  {
    abort_unless(in_array($kategori, ['baru', 'lama'], true), 404);

    $today = now()->toDateString();
    $query = Pasien::with('pengguna')->whereHas('pengguna', function ($q) {
      $q->where('role', 'pasien');
    });

    if ($kategori === 'baru') {
      $query->whereDate('created_at', $today);
      $judul = 'Pasien Baru';
      $deskripsi = 'Pasien yang terdaftar hari ini.';
    } else {
      $query->whereDate('created_at', '<', $today);
      $judul = 'Pasien Lama';
      $deskripsi = 'Pasien yang terdaftar sebelum hari ini.';
    }

    if ($request->filled('search')) {
      $search = trim($request->search);

      $query->where(function ($q) use ($search) {
        $q->whereHas('pengguna', function ($userQuery) use ($search) {
          $userQuery->where('name', 'like', '%' . $search . '%');
        })->orWhere('nik', 'like', '%' . $search . '%');
      });
    }

    $pasiens = $query->latest()->paginate(10)->withQueryString();

    return view('admin.pasien.kategori', compact('pasiens', 'kategori', 'judul', 'deskripsi'));
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
      'password' => 'required|string|min:6|confirmed',
    ]);

    $user = User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
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
      'password' => 'nullable|string|min:6|confirmed',
    ]);

    // update user
    if ($pasien->pengguna) {
      $userData = [
        'name' => $data['name'],
        'email' => $data['email'],
      ];

      if (!empty($data['password'])) {
        $userData['password'] = Hash::make($data['password']);
      }

      $pasien->pengguna->update($userData);
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
