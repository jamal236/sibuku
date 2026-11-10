<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransaksiRequest;
use App\Models\Buku;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Services\TransaksiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    protected $transaksiService;

    /**
     * Constructor - Dependency Injection TransaksiService
     */
    public function __construct(TransaksiService $transaksiService)
    {
        $this->transaksiService = $transaksiService;
    }

    /**
     * Daftar Transaksi
     */
    public function index(Request $request)
    {
        $query = Transaksi::with(['kasir', 'pelanggan', 'detail.buku']);

        // Filter tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search kode transaksi
        if ($request->filled('search')) {
            $query->where('kode_transaksi', 'like', "%{$request->search}%");
        }

        // Jika user TIDAK punya permission lihat-semua (kasir), hanya lihat transaksi sendiri
        if (!auth()->user()->can('transaksi.lihat-semua')) {
            $query->where('user_id', auth()->id());
        }

        $transaksis = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('transaksi.index', compact('transaksis'));
    }

    /**
     * Form Transaksi Baru (POS)
     */
    public function create()
    {
        $pelanggans = Pelanggan::orderBy('nama')->get();
        return view('transaksi.create', compact('pelanggans'));
    }

    /**
     * Simpan Transaksi Baru
     */
    public function store(TransaksiRequest $request)
    {
        try {
            $transaksi = $this->transaksiService->prosesTransaksi($request->validated());

            return redirect()
                ->route('transaksi.nota', $transaksi)
                ->with('success', 'Transaksi berhasil diproses!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Detail Transaksi
     */
    public function show(Transaksi $transaksi)
    {
        // Cek permission - kasir hanya bisa lihat transaksi sendiri
        if (!auth()->user()->can('transaksi.lihat-semua')) {
            if ($transaksi->user_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses ke transaksi ini.');
            }
        }

        $transaksi->load(['kasir', 'pelanggan', 'detail.buku']);
        return view('transaksi.show', compact('transaksi'));
    }

    /**
     * Cetak Nota
     */
    public function nota(Transaksi $transaksi)
    {
        // Cek permission - kasir hanya bisa lihat nota transaksi sendiri
        if (!auth()->user()->can('transaksi.lihat-semua')) {
            if ($transaksi->user_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses ke transaksi ini.');
            }
        }

        $transaksi->load(['kasir', 'pelanggan', 'detail.buku']);
        return view('transaksi.nota', compact('transaksi'));
    }

    /**
     * Batalkan Transaksi
     */
    public function batal(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'alasan_batal' => 'required|string|max:1000',
        ]);

        try {
            // Cek apakah transaksi sudah dibatalkan
            if ($transaksi->status === 'dibatalkan') {
                return back()->with('error', 'Transaksi sudah dibatalkan sebelumnya.');
            }

            $this->transaksiService->batalkanTransaksi($transaksi, $request->alasan_batal);

            return back()->with('success', 'Transaksi berhasil dibatalkan.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * API untuk pencarian buku (digunakan di POS)
     */
    public function cariBuku(Request $request)
    {
        $search = $request->get('q', '');

        $bukus = Buku::where('is_aktif', true)
            ->where('stok', '>', 0)
            ->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('kode_buku', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%");
            })
            ->with('kategori')
            ->limit(10)
            ->get()
            ->map(function($buku) {
                return [
                    'id' => $buku->id,
                    'kode_buku' => $buku->kode_buku,
                    'judul' => $buku->judul,
                    'pengarang' => $buku->pengarang,
                    'harga' => $buku->harga,
                    'stok' => $buku->stok,
                    'kondisi' => ucfirst(str_replace('_', ' ', $buku->kondisi)),
                    'kategori' => $buku->kategori ? $buku->kategori->nama_kategori : '-',
                    'foto' => $buku->foto ? asset('storage/' . $buku->foto) : null,
                ];
            });

        return response()->json($bukus);
    }
}