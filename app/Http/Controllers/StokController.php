<?php

namespace App\Http\Controllers;

use App\Http\Requests\StokMasukRequest;
use App\Models\Buku;
use App\Models\RiwayatStok;
use App\Models\StokMasuk;
use App\Models\Supplier;
use App\Services\StokService;
use Illuminate\Http\Request;

class StokController extends Controller
{
    protected $stokService;

    /**
     * Constructor - Dependency Injection StokService
     */
    public function __construct(StokService $stokService)
    {
        $this->stokService = $stokService;
    }

    /**
     * Daftar Stok Masuk
     */
    public function index(Request $request)
    {
        $query = StokMasuk::with(['buku', 'supplier', 'user']);

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        if ($request->filled('search')) {
            $query->where('kode_stok_masuk', 'like', "%{$request->search}%");
        }

        $stokMasuks = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $suppliers = Supplier::orderBy('nama')->get();

        return view('stok.index', compact('stokMasuks', 'suppliers'));
    }

    /**
     * Form Catat Stok Masuk
     */
    public function create()
    {
        $bukus = Buku::where('is_aktif', true)->orderBy('judul')->get();
        $suppliers = Supplier::orderBy('nama')->get();
        
        return view('stok.create', compact('bukus', 'suppliers'));
    }

    /**
     * Simpan Stok Masuk
     */
    public function store(StokMasukRequest $request)
    {
        try {
            $stokMasuk = $this->stokService->catatStokMasuk($request->validated());

            return redirect()
                ->route('stok.show', $stokMasuk)
                ->with('success', 'Stok masuk berhasil dicatat!');
        } catch (\Exception $e) {
            \Log::error('Error saat menyimpan stok masuk: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Gagal mencatat stok masuk: ' . $e->getMessage());
        }
    }

    /**
     * Detail Stok Masuk
     */
    public function show(StokMasuk $stokMasuk)
    {
        $stokMasuk->load(['buku.kategori', 'supplier', 'user']);
        
        $riwayatStok = RiwayatStok::where('stok_masuk_id', $stokMasuk->id)->first();

        return view('stok.show', compact('stokMasuk', 'riwayatStok'));
    }
}