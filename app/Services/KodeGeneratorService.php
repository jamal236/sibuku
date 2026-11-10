<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\Pelanggan;
use App\Models\Supplier;
use App\Models\Transaksi;
use App\Models\StokMasuk;

class KodeGeneratorService
{
    public static function generateKodeBuku()
    {
        $lastBuku = Buku::orderBy('id', 'desc')->first();
        $lastNumber = $lastBuku ? intval(substr($lastBuku->kode_buku, -5)) : 0;
        $newNumber = $lastNumber + 1;
        return 'BKU-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }

    public static function generateKodePelanggan()
    {
        $lastPelanggan = Pelanggan::orderBy('id', 'desc')->first();
        $lastNumber = $lastPelanggan ? intval(substr($lastPelanggan->kode_pelanggan, -5)) : 0;
        $newNumber = $lastNumber + 1;
        return 'PLG-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }

    public static function generateKodeSupplier()
    {
        $lastSupplier = Supplier::orderBy('id', 'desc')->first();
        $lastNumber = $lastSupplier ? intval(substr($lastSupplier->kode_supplier, -3)) : 0;
        $newNumber = $lastNumber + 1;
        return 'SUP-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public static function generateKodeTransaksi()
    {
        $today = date('Ymd');
        $lastTransaksi = Transaksi::where('kode_transaksi', 'like', "TRX-{$today}-%")
            ->orderBy('id', 'desc')
            ->first();
        
        $lastNumber = $lastTransaksi ? intval(substr($lastTransaksi->kode_transaksi, -3)) : 0;
        $newNumber = $lastNumber + 1;
        return 'TRX-' . $today . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public static function generateKodeStokMasuk()
    {
        $today = date('Ymd');
        $lastStok = StokMasuk::where('kode_stok_masuk', 'like', "STK-IN-{$today}-%")
            ->orderBy('id', 'desc')
            ->first();
        
        $lastNumber = $lastStok ? intval(substr($lastStok->kode_stok_masuk, -3)) : 0;
        $newNumber = $lastNumber + 1;
        return 'STK-IN-' . $today . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}