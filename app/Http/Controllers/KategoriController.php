<?php

namespace App\Http\Controllers;

use App\Http\Requests\KategoriRequest;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{

    public function index(Request $request)
    {
        $query = Kategori::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_kategori', 'like', "%{$search}%");
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('is_aktif', $request->status === 'aktif');
        }

        $kategoris = $query->orderBy('urutan_tampil')->orderBy('nama_kategori')->paginate(10)->withQueryString();

        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(KategoriRequest $request)
    {
        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'warna_label' => $request->warna_label,
            'urutan_tampil' => $request->urutan_tampil ?? 99,
            'is_aktif' => $request->has('is_aktif'),
        ]);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(KategoriRequest $request, Kategori $kategori)
    {
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'warna_label' => $request->warna_label,
            'urutan_tampil' => $request->urutan_tampil ?? 99,
            'is_aktif' => $request->has('is_aktif'),
        ]);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Kategori $kategori)
    {
        // Cek apakah ada buku yang menggunakan kategori ini
        if ($kategori->buku()->where('is_aktif', true)->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh buku aktif.');
        }

        $kategori->delete();

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}