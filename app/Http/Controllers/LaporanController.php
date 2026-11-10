<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\DetailTransaksi;
use App\Models\Kategori;
use App\Models\Pelanggan;
use App\Models\Supplier;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Halaman Utama Pusat Laporan
     */
    public function index()
    {
        // Penjualan hari ini
        $penjualanHariIni = Transaksi::whereDate('tanggal', today())
            ->where('status', 'selesai')
            ->sum('total_setelah_diskon');

        $transaksiHariIni = Transaksi::whereDate('tanggal', today())
            ->where('status', 'selesai')
            ->count();

        // Stok rendah
        $stokRendah = Buku::whereColumn('stok', '<=', 'stok_minimum')
            ->where('is_aktif', true)
            ->count();

        // ✅ STATISTIK TAMBAHAN UNTUK BAGIAN BAWAH
        $totalBuku = Buku::count();
        $bukuAktif = Buku::where('is_aktif', true)->count();
        $totalPelanggan = Pelanggan::count();
        $totalSupplier = Supplier::count();

        return view('laporan.index', compact(
            'penjualanHariIni',
            'transaksiHariIni',
            'stokRendah',
            'totalBuku',
            'bukuAktif',
            'totalPelanggan',
            'totalSupplier'
        ));
    }

    /**
     * Laporan Penjualan
     */
    public function penjualan(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        $userId = $request->get('user_id');

        $query = Transaksi::with(['kasir', 'pelanggan', 'detail'])
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->where('status', 'selesai');

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $transaksis = $query->orderBy('tanggal', 'desc')->get();
        $kasirs = \App\Models\User::role('kasir')->get();

        $totalTransaksi = $transaksis->count();
        $totalPendapatan = $transaksis->sum('total_setelah_diskon');
        $totalItem = $transaksis->sum(function($trx) {
            return $trx->detail->sum('jumlah');
        });

        return view('laporan.penjualan', compact(
            'transaksis',
            'kasirs',
            'startDate',
            'endDate',
            'totalTransaksi',
            'totalPendapatan',
            'totalItem'
        ));
    }

    /**
     * Laporan Stok
     */
    public function stok(Request $request)
    {
        $search = $request->get('search');
        $kategoriId = $request->get('kategori_id');
        $stokRendah = $request->get('stok_rendah');

        $query = Buku::with(['kategori'])
            ->where('is_aktif', true);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('kode_buku', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%");
            });
        }

        if ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        }

        if ($stokRendah) {
            $query->whereColumn('stok', '<=', 'stok_minimum');
        }

        $bukus = $query->orderBy('judul')->get();
        $kategoris = Kategori::where('is_aktif', true)->orderBy('nama_kategori')->get();

        $totalBuku = $bukus->count();
        $totalStok = $bukus->sum('stok');
        $nilaiInventaris = $bukus->sum(function($buku) {
            return $buku->stok * $buku->harga;
        });

        return view('laporan.stok', compact(
            'bukus',
            'kategoris',
            'totalBuku',
            'totalStok',
            'nilaiInventaris'
        ));
    }

    /**
     * Laporan Kategori
     */
    public function kategori(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        $kategoriId = $request->get('kategori_id');

        // Query kategori dengan data penjualan
        // PERHATIAN: Nama tabel database adalah 'kategori' (singular)
        $query = Kategori::select(
                'kategori.*',
                DB::raw('COUNT(DISTINCT detail_transaksi.buku_id) as total_buku'),
                DB::raw('COUNT(DISTINCT transaksi.id) as total_transaksi'),
                DB::raw('COALESCE(SUM(detail_transaksi.jumlah), 0) as total_terjual'),
                DB::raw('COALESCE(SUM(detail_transaksi.subtotal), 0) as total_pendapatan')
            )
            ->leftJoin('buku', 'kategori.id', '=', 'buku.kategori_id')
            ->leftJoin('detail_transaksi', 'buku.id', '=', 'detail_transaksi.buku_id')
            ->leftJoin('transaksi', function($join) use ($startDate, $endDate) {
                $join->on('detail_transaksi.transaksi_id', '=', 'transaksi.id')
                     ->where('transaksi.status', '=', 'selesai')
                     ->whereBetween('transaksi.tanggal', [$startDate, $endDate]);
            })
            ->where('kategori.is_aktif', true);

        if ($kategoriId) {
            $query->where('kategori.id', $kategoriId);
        }

        $kategoriData = $query->groupBy(
                'kategori.id', 
                'kategori.nama_kategori', 
                'kategori.warna_label', 
                'kategori.deskripsi', 
                'kategori.urutan_tampil', 
                'kategori.is_aktif', 
                'kategori.created_at', 
                'kategori.updated_at'
            )
            ->orderBy('total_pendapatan', 'desc')
            ->get();

        $kategoris = Kategori::where('is_aktif', true)->orderBy('nama_kategori')->get();

        $totalKategori = $kategoriData->count();
        $totalTransaksi = $kategoriData->sum('total_transaksi');
        $totalItem = $kategoriData->sum('total_terjual');
        $totalPendapatan = $kategoriData->sum('total_pendapatan');

        return view('laporan.kategori', compact(
            'kategoriData',
            'kategoris',
            'startDate',
            'endDate',
            'totalKategori',
            'totalTransaksi',
            'totalItem',
            'totalPendapatan'
        ));
    }
}