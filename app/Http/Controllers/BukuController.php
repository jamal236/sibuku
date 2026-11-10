<?php

namespace App\Http\Controllers;

use App\Http\Requests\BukuRequest;
use App\Models\Buku;
use App\Models\Kategori;
use App\Services\KodeGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%")
                  ->orWhere('kode_buku', 'like', "%{$search}%");
            });
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter kondisi
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('is_aktif', $request->status === 'aktif');
        }

        $bukus = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();
        $kategoris = Kategori::where('is_aktif', true)->orderBy('nama_kategori')->get();

        return view('buku.index', compact('bukus', 'kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::where('is_aktif', true)->orderBy('nama_kategori')->get();
        $kodeBuku = KodeGeneratorService::generateKodeBuku();
        
        return view('buku.create', compact('kategoris', 'kodeBuku'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BukuRequest $request)
    {
        $data = $request->validated();
        $data['kode_buku'] = KodeGeneratorService::generateKodeBuku();
        $data['created_by'] = auth()->id();
        $data['is_aktif'] = $request->has('is_aktif');

        // Handle upload foto
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('buku', 'public');
        }

        Buku::create($data);

        return redirect()
            ->route('buku.index')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Buku $buku)
    {
        $buku->load(['kategori', 'creator', 'riwayatStok.user']);
        return view('buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $buku)
    {
        $kategoris = Kategori::where('is_aktif', true)->orderBy('nama_kategori')->get();
        return view('buku.edit', compact('buku', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BukuRequest $request, Buku $buku)
    {
        $data = $request->validated();
        $data['is_aktif'] = $request->has('is_aktif');

        // Handle upload foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($buku->foto) {
                Storage::disk('public')->delete($buku->foto);
            }
            $data['foto'] = $request->file('foto')->store('buku', 'public');
        }

        $buku->update($data);

        return redirect()
            ->route('buku.index')
            ->with('success', 'Buku berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku)
    {
        // Cek apakah buku pernah digunakan di transaksi
        if ($buku->detailTransaksi()->exists()) {
            return back()->with('error', 'Buku tidak dapat dihapus karena pernah digunakan dalam transaksi.');
        }

        // Hapus foto jika ada
        if ($buku->foto) {
            Storage::disk('public')->delete($buku->foto);
        }

        $buku->delete();

        return redirect()
            ->route('buku.index')
            ->with('success', 'Buku berhasil dihapus!');
    }
}