<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\RiwayatStok;
use App\Models\StokMasuk;
use Illuminate\Support\Facades\DB;

class StokService
{
    /**
     * Catat stok masuk baru
     */
    public function catatStokMasuk(array $data): StokMasuk
    {
        return DB::transaction(function () use ($data) {
            // Generate kode stok masuk
            $kodeStokMasuk = $this->generateKodeStokMasuk();

            // Hitung total harga beli
            $jumlah = $data['jumlah'];
            $hargaBeli = $data['harga_beli'] ?? null;
            $totalHargaBeli = $hargaBeli ? ($jumlah * $hargaBeli) : null;

            // Buat record stok masuk
            $stokMasuk = StokMasuk::create([
                'kode_stok_masuk' => $kodeStokMasuk,
                'buku_id' => $data['buku_id'],
                'supplier_id' => $data['supplier_id'],
                'user_id' => auth()->id(),
                'tanggal' => $data['tanggal'],
                'jumlah' => $jumlah,
                'harga_beli' => $hargaBeli,
                'total_harga_beli' => $totalHargaBeli,
                'keterangan' => $data['keterangan'] ?? null,
            ]);

            // Update stok buku
            $buku = Buku::findOrFail($data['buku_id']);
            $stokSebelum = $buku->stok;
            $buku->increment('stok', $jumlah);
            $stokSesudah = $buku->stok;

            // Catat riwayat stok
            RiwayatStok::create([
                'buku_id' => $data['buku_id'],
                'user_id' => auth()->id(),
                'stok_masuk_id' => $stokMasuk->id,
                'jenis_perubahan' => 'masuk',
                'jumlah' => $jumlah,
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $stokSesudah,
                'keterangan' => 'Stok masuk dari ' . $stokMasuk->supplier->nama . ' (' . $kodeStokMasuk . ')',
            ]);

            return $stokMasuk;
        });
    }

    /**
     * Generate kode stok masuk unik
     * Format: SM20260617001
     */
    private function generateKodeStokMasuk(): string
    {
        $prefix = 'SM';
        $date = now()->format('Ymd');
        
        // Cari stok masuk terakhir hari ini
        $lastStokMasuk = StokMasuk::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastStokMasuk) {
            $lastNumber = (int) substr($lastStokMasuk->kode_stok_masuk, -3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . $date . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}