<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * StoreTransaksiRequest
 *
 * Validasi input dari halaman kasir (Bagian 6.1 rancangan arsitektur).
 *
 * Catatan penting: 'harga_satuan' SENGAJA TIDAK divalidasi/diterima
 * dari request sama sekali. TransaksiService akan mengambil harga
 * langsung dari tabel buku berdasarkan 'buku_id', sehingga kasir
 * tidak bisa memanipulasi harga lewat request yang dimodifikasi
 * (lihat catatan keamanan di TransaksiService).
 */
class StoreTransaksiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pelanggan_id'             => ['nullable', 'integer', 'exists:pelanggan,id'],
            'metode_bayar'             => ['required', 'string', 'in:tunai,transfer,qris'],
            'diskon'                   => ['nullable', 'numeric', 'min:0'],
            'bayar'                    => ['required', 'numeric', 'min:0'],
            'catatan'                  => ['nullable', 'string', 'max:500'],

            'items'                    => ['required', 'array', 'min:1'],
            'items.*.buku_id'          => ['required', 'integer', 'exists:buku,id', 'distinct'],
            'items.*.jumlah'           => ['required', 'integer', 'min:1'],
            'items.*.diskon_item'      => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'pelanggan_id.exists'    => 'Data pelanggan tidak ditemukan.',
            'metode_bayar.required'  => 'Metode pembayaran wajib dipilih.',
            'metode_bayar.in'        => 'Metode pembayaran tidak valid.',
            'bayar.required'         => 'Jumlah uang yang dibayarkan wajib diisi.',
            'bayar.min'              => 'Jumlah bayar tidak boleh negatif.',

            'items.required'         => 'Transaksi harus memiliki minimal 1 buku.',
            'items.min'              => 'Transaksi harus memiliki minimal 1 buku.',
            'items.*.buku_id.required'=> 'Data buku tidak valid.',
            'items.*.buku_id.exists' => 'Buku yang dipilih tidak ditemukan.',
            'items.*.buku_id.distinct'=> 'Setiap buku hanya boleh muncul satu kali. Gabungkan jumlahnya pada satu baris.',
            'items.*.jumlah.required'=> 'Jumlah pembelian wajib diisi.',
            'items.*.jumlah.min'     => 'Jumlah pembelian minimal 1.',
        ];
    }
}
