<?php

namespace App\Http\Controllers;

use App\Http\Requests\PelangganRequest;
use App\Models\Pelanggan;
use App\Services\KodeGeneratorService;
use Illuminate\Http\Request;

class PelangganController extends Controller
{

    public function index(Request $request)
    {
        $query = Pelanggan::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%")
                  ->orWhere('kode_pelanggan', 'like', "%{$search}%");
            });
        }

        $pelanggans = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('pelanggan.index', compact('pelanggans'));
    }

    public function create()
    {
        $kodePelanggan = KodeGeneratorService::generateKodePelanggan();
        return view('pelanggan.create', compact('kodePelanggan'));
    }

    public function store(PelangganRequest $request)
    {
        $data = $request->validated();
        $data['kode_pelanggan'] = KodeGeneratorService::generateKodePelanggan();
        $data['created_by'] = auth()->id();

        Pelanggan::create($data);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(PelangganRequest $request, Pelanggan $pelanggan)
    {
        $pelanggan->update($request->validated());

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        // Cek apakah pelanggan memiliki riwayat transaksi
        if ($pelanggan->transaksi()->exists()) {
            return back()->with('error', 'Pelanggan tidak dapat dihapus karena memiliki riwayat transaksi. Data transaksi akan tetap tercatat.');
        }

        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus!');
    }
}