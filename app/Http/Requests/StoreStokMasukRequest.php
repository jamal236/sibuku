<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * StoreStokMasukRequest
 *
 * Validasi input pencatatan stok buku masuk dari supplier/donatur
 * (Bagian 6.2 rancangan arsitektur: "Alur Pencatatan Stok Masuk").
 *
 * Aturan bisnis: jika supplier berjenis 'donatur', harga_beli boleh
 * kosong (buku diberikan gratis). Validasi jenis supplier dilakukan
 * di controller karena memerlukan query ke tabel supplier.
 */
class StoreStokMasukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'buku_id'     => ['required', 'integer', 'exists:buku,id'],
            'supplier_id' => ['required', 'integer', 'exists:supplier,id'],
            'jumlah'      => ['required', 'integer', 'min:1'],
            'harga_beli'  => ['nullable', 'numeric', 'min:0'],
            'tanggal'     => ['required', 'date', 'before_or_equal:today'],
            'keterangan'  => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'buku_id.required'     => 'Buku yang masuk wajib dipilih.',
            'buku_id.exists'       => 'Buku tidak ditemukan.',
            'supplier_id.required' => 'Supplier/donatur wajib dipilih.',
            'supplier_id.exists'   => 'Supplier/donatur tidak ditemukan.',
            'jumlah.required'      => 'Jumlah buku yang masuk wajib diisi.',
            'jumlah.min'           => 'Jumlah buku yang masuk minimal 1.',
            'tanggal.required'     => 'Tanggal penerimaan wajib diisi.',
            'tanggal.before_or_equal' => 'Tanggal penerimaan tidak boleh di masa depan.',
        ];
    }
}
