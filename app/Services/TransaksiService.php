<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class TransaksiService
{
    /**
     * Proses transaksi baru
     */
    public function prosesTransaksi(array $data): Transaksi
    {
        return DB::transaction(function () use ($data) {
            // Generate kode transaksi
            $kodeTransaksi = $this->generateKodeTransaksi();

            // Hitung total
            $items = $data['items'];
            $total = 0;
            foreach ($items as $item) {
                $subtotal = $item['harga'] * $item['jumlah'] - ($item['diskon'] ?? 0);
                $total += $subtotal;
            }

            $diskon = $data['diskon'] ?? 0;
            $totalSetelahDiskon = $total - $diskon;

            // Buat transaksi
            $transaksi = Transaksi::create([
                'kode_transaksi' => $kodeTransaksi,
                'user_id' => auth()->id(),
                'pelanggan_id' => $data['pelanggan_id'] ?? null,
                'tanggal' => now(),
                'total' => $total,
                'diskon' => $diskon,
                'total_setelah_diskon' => $totalSetelahDiskon,
                'metode_bayar' => $data['metode_bayar'],
                'bayar' => $data['bayar'],
                'kembalian' => max(0, $data['bayar'] - $totalSetelahDiskon),
                'catatan' => $data['catatan'] ?? null,
                'status' => 'selesai',
            ]);

            // Simpan detail transaksi & update stok
            foreach ($items as $item) {
                $buku = Buku::findOrFail($item['buku_id']);
                
                // Validasi stok
                if ($buku->stok < $item['jumlah']) {
                    throw new \Exception("Stok buku '{$buku->judul}' tidak mencukupi. Tersedia: {$buku->stok}");
                }

                $subtotal = $item['harga'] * $item['jumlah'] - ($item['diskon'] ?? 0);

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'buku_id' => $buku->id,
                    'judul_snapshot' => $buku->judul,
                    'kondisi_snapshot' => $buku->kondisi,
                    'harga_satuan' => $item['harga'],
                    'jumlah' => $item['jumlah'],
                    'diskon_item' => $item['diskon'] ?? 0,
                    'subtotal' => $subtotal,
                ]);

                // Kurangi stok buku
                $buku->decrement('stok', $item['jumlah']);
            }

            return $transaksi;
        });
    }

    /**
     * Batalkan transaksi
     */
    public function batalkanTransaksi(Transaksi $transaksi, string $alasan): void
    {
        DB::transaction(function () use ($transaksi, $alasan) {
            // Kembalikan stok buku
            foreach ($transaksi->detail as $item) {
                $buku = Buku::find($item->buku_id);
                if ($buku) {
                    $buku->increment('stok', $item->jumlah);
                }
            }

            // Update status transaksi
            $transaksi->update([
                'status' => 'dibatalkan',
                'alasan_batal' => $alasan,
            ]);
        });
    }

    /**
     * Generate kode transaksi unik
     */
    private function generateKodeTransaksi(): string
    {
        $prefix = 'TRX';
        $date = now()->format('Ymd');
        
        // Cari transaksi terakhir hari ini
        $lastTransaksi = Transaksi::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastTransaksi) {
            // Ambil nomor urut dari kode terakhir
            $lastNumber = (int) substr($lastTransaksi->kode_transaksi, -3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . $date . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}