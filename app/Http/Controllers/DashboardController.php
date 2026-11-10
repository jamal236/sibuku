<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use App\Models\StokMasuk;
use App\Models\Supplier;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->hasRole('admin')) {
            return $this->dashboardAdmin();
        } elseif ($user->hasRole('kasir')) {
            return $this->dashboardKasir();
        } elseif ($user->hasRole('owner')) {
            return $this->dashboardOwner();
        }
        
        // Fallback ke dashboard admin jika role tidak dikenali
        return $this->dashboardAdmin();
    }

    /**
     * Dashboard Admin - Fokus: Inventori & Operasional
     */
    private function dashboardAdmin()
    {
        // Total buku unik (judul) dan total eksemplar
        $totalJudulBuku = Buku::where('is_aktif', true)->count();
        $totalEksemplar = Buku::where('is_aktif', true)->sum('stok');
        
        // Buku dengan stok > 1 (variasi eksemplar)
        $bukuMultiEksemplar = Buku::where('is_aktif', true)->where('stok', '>', 1)->count();
        
        // Stok rendah & stok habis
        $stokRendah = Buku::whereColumn('stok', '<=', 'stok_minimum')
            ->where('is_aktif', true)
            ->count();
        
        $stokHabis = Buku::where('stok', 0)
            ->where('is_aktif', true)
            ->count();
        
        // Stok masuk bulan ini
        $stokMasukBulanIni = StokMasuk::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();
        
        $totalBiayaStokMasuk = StokMasuk::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('total_harga_beli');
        
        // Top 5 Supplier/Donatur bulan ini
        $topSuppliers = StokMasuk::select('supplier.nama', DB::raw('COUNT(stok_masuk.id) as total_kiriman'), DB::raw('SUM(stok_masuk.jumlah) as total_buku'))
            ->join('supplier', 'stok_masuk.supplier_id', '=', 'supplier.id')
            ->whereMonth('stok_masuk.tanggal', now()->month)
            ->whereYear('stok_masuk.tanggal', now()->year)
            ->groupBy('supplier.id', 'supplier.nama')
            ->orderBy('total_buku', 'desc')
            ->limit(5)
            ->get();
        
        // Dead stock (buku yang tidak laku > 6 bulan dan stok > 0)
        $deadStock = Buku::where('is_aktif', true)
            ->where('stok', '>', 0)
            ->whereDoesntHave('detailTransaksi.transaksi', function($q) {
                $q->where('tanggal', '>=', now()->subMonths(6));
            })
            ->count();
        
        // Buku stok rendah untuk alert
        $bukuStokRendah = Buku::whereColumn('stok', '<=', 'stok_minimum')
            ->where('is_aktif', true)
            ->orderBy('stok')
            ->limit(5)
            ->get();
        
        return view('dashboard.admin', compact(
            'totalJudulBuku', 'totalEksemplar', 'bukuMultiEksemplar',
            'stokRendah', 'stokHabis', 'stokMasukBulanIni', 'totalBiayaStokMasuk',
            'topSuppliers', 'deadStock', 'bukuStokRendah'
        ));
    }

    /**
     * Dashboard Kasir - Fokus: Operasional Harian
     */
    private function dashboardKasir()
    {
        $userId = auth()->id();
        
        // Transaksi hari ini (kasir ini)
        $transaksiHariIni = Transaksi::where('user_id', $userId)
            ->whereDate('tanggal', today())
            ->where('status', 'selesai')
            ->count();
        
        $pendapatanHariIni = Transaksi::where('user_id', $userId)
            ->whereDate('tanggal', today())
            ->where('status', 'selesai')
            ->sum('total_setelah_diskon');
        
        // Total item terjual hari ini
        $transaksiIdsHariIni = Transaksi::where('user_id', $userId)
            ->whereDate('tanggal', today())
            ->where('status', 'selesai')
            ->pluck('id');
        
        $itemTerjualHariIni = DetailTransaksi::whereIn('transaksi_id', $transaksiIdsHariIni)->sum('jumlah');
        
        // Rata-rata nilai transaksi hari ini
        $rataRataTransaksi = $transaksiHariIni > 0 ? $pendapatanHariIni / $transaksiHariIni : 0;
        
        // Pelanggan dilayani hari ini
        $pelangganHariIni = Transaksi::where('user_id', $userId)
            ->whereDate('tanggal', today())
            ->where('status', 'selesai')
            ->whereNotNull('pelanggan_id')
            ->distinct('pelanggan_id')
            ->count('pelanggan_id');
        
        // Metode pembayaran terpopuler hari ini
        $metodeBayar = Transaksi::where('user_id', $userId)
            ->whereDate('tanggal', today())
            ->where('status', 'selesai')
            ->select('metode_bayar', DB::raw('COUNT(*) as total'))
            ->groupBy('metode_bayar')
            ->orderBy('total', 'desc')
            ->get();
        
// Analisis jam sibuk (transaksi per jam hari ini)
$jamExpression = DB::connection()->getDriverName() === 'sqlite'
    ? "CAST(strftime('%H', created_at) AS INTEGER)"
    : "HOUR(created_at)";

$jamSibuk = Transaksi::where('user_id', $userId)
    ->whereDate('tanggal', today())
    ->where('status', 'selesai')
    ->selectRaw("$jamExpression as jam, COUNT(*) as total")
    ->groupBy('jam')
    ->orderBy('jam')
    ->get();
        
        // Transaksi terbaru (milik kasir ini)
        $transaksiTerbaru = Transaksi::with('pelanggan')
            ->where('user_id', $userId)
            ->where('status', 'selesai')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Buku stok rendah (untuk info ke pelanggan)
        $bukuStokRendah = Buku::whereColumn('stok', '<=', 'stok_minimum')
            ->where('is_aktif', true)
            ->orderBy('stok')
            ->limit(5)
            ->get();
        
        return view('dashboard.kasir', compact(
            'transaksiHariIni', 'pendapatanHariIni', 'itemTerjualHariIni',
            'rataRataTransaksi', 'pelangganHariIni', 'metodeBayar',
            'jamSibuk', 'transaksiTerbaru', 'bukuStokRendah'
        ));
    }

    /**
     * Dashboard Owner - Fokus: Finansial & Strategis
     */
    private function dashboardOwner()
    {
        // Pendapatan bulan ini
        $pendapatanBulanIni = Transaksi::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->where('status', 'selesai')
            ->sum('total_setelah_diskon');
        
        // Pendapatan bulan lalu (untuk perbandingan)
        $pendapatanBulanLalu = Transaksi::whereMonth('tanggal', now()->subMonth()->month)
            ->whereYear('tanggal', now()->subMonth()->year)
            ->where('status', 'selesai')
            ->sum('total_setelah_diskon');
        
        // Persentase pertumbuhan
        $pertumbuhan = $pendapatanBulanLalu > 0 
            ? (($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100 
            : 0;
        
        // Total transaksi bulan ini
        $totalTransaksiBulanIni = Transaksi::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->where('status', 'selesai')
            ->count();
        
        // Biaya pengadaan stok bulan ini (dari supplier, bukan donatur)
        $biayaPengadaan = StokMasuk::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->whereNotNull('total_harga_beli')
            ->sum('total_harga_beli');
        
        // Net Profit (pendapatan - biaya pengadaan)
        $netProfit = $pendapatanBulanIni - $biayaPengadaan;
        
        // Margin profit
        $marginProfit = $pendapatanBulanIni > 0 ? ($netProfit / $pendapatanBulanIni) * 100 : 0;
        
        // Rata-rata nilai transaksi
        $rataRataTransaksi = $totalTransaksiBulanIni > 0 
            ? $pendapatanBulanIni / $totalTransaksiBulanIni 
            : 0;
        
        // Profitabilitas berdasarkan kondisi buku (grade)
        $profitPerGrade = DetailTransaksi::join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
            ->whereMonth('transaksi.tanggal', now()->month)
            ->whereYear('transaksi.tanggal', now()->year)
            ->where('transaksi.status', 'selesai')
            ->select('detail_transaksi.kondisi_snapshot', 
                    DB::raw('COUNT(*) as total_terjual'),
                    DB::raw('SUM(detail_transaksi.subtotal) as total_pendapatan'))
            ->groupBy('detail_transaksi.kondisi_snapshot')
            ->orderBy('total_pendapatan', 'desc')
            ->get();
        
        // Grafik pendapatan 30 hari terakhir
        $chartLabels = [];
        $chartData = [];
        
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('d M');
            
            $pendapatan = Transaksi::whereDate('tanggal', $date)
                ->where('status', 'selesai')
                ->sum('total_setelah_diskon');
            
            $chartData[] = $pendapatan;
        }
        
        // Top 5 buku terlaris bulan ini
        $topBuku = DetailTransaksi::join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
            ->whereMonth('transaksi.tanggal', now()->month)
            ->whereYear('transaksi.tanggal', now()->year)
            ->where('transaksi.status', 'selesai')
            ->select('detail_transaksi.judul_snapshot', 
                    DB::raw('SUM(detail_transaksi.jumlah) as total_terjual'),
                    DB::raw('SUM(detail_transaksi.subtotal) as total_pendapatan'))
            ->groupBy('detail_transaksi.judul_snapshot')
            ->orderBy('total_terjual', 'desc')
            ->limit(5)
            ->get();
        
        // Performa kasir bulan ini
        $performaKasir = Transaksi::join('users', 'transaksi.user_id', '=', 'users.id')
            ->whereMonth('transaksi.tanggal', now()->month)
            ->whereYear('transaksi.tanggal', now()->year)
            ->where('transaksi.status', 'selesai')
            ->select('users.name', 
                    DB::raw('COUNT(transaksi.id) as total_transaksi'),
                    DB::raw('SUM(transaksi.total_setelah_diskon) as total_penjualan'))
            ->groupBy('users.id', 'users.name')
            ->orderBy('total_penjualan', 'desc')
            ->get();
        
        // Arus kas bulan ini
        $kasMasuk = $pendapatanBulanIni;
        $kasKeluar = $biayaPengadaan;
        $arusKasBersih = $kasMasuk - $kasKeluar;
        
        return view('dashboard.owner', compact(
            'pendapatanBulanIni', 'pendapatanBulanLalu', 'pertumbuhan',
            'totalTransaksiBulanIni', 'biayaPengadaan', 'netProfit', 'marginProfit',
            'rataRataTransaksi', 'profitPerGrade', 'chartLabels', 'chartData',
            'topBuku', 'performaKasir', 'kasMasuk', 'kasKeluar', 'arusKasBersih'
        ));
    }
}