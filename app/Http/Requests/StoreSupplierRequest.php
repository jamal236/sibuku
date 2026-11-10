<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * StoreSupplierRequest
 *
 * Validasi input data supplier/donatur (Bagian 2.1: supplier/index.blade.php
 * dan Bagian 7 mengenai manajemen supplier dan donatur buku).
 * Digunakan untuk store maupun update.
 */
class StoreSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama'       => ['required', 'string', 'max:255'],
            'jenis'      => ['required', 'string', 'in:supplier,donatur'],
            'telepon'    => ['nullable', 'string', 'max:20'],
            'email'      => ['nullable', 'email', 'max:255'],
            'alamat'     => ['nullable', 'string'],
            'keterangan' => ['nullable', 'string'],
            'is_aktif'   => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required'  => 'Nama supplier/donatur wajib diisi.',
            'jenis.required' => 'Jenis (supplier atau donatur) wajib dipilih.',
            'jenis.in'       => 'Jenis harus berupa supplier atau donatur.',
            'email.email'    => 'Format email tidak valid.',
        ];
    }
}
