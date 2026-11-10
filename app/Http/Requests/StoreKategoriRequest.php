<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKategoriRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Otorisasi sesungguhnya ditangani oleh middleware 'permission:kategori.kelola'
        // pada route. Method ini selalu true karena route sudah diproteksi.
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_kategori' => ['required', 'string', 'max:255', 'unique:kategori,nama_kategori'],
            'deskripsi'     => ['nullable', 'string'],
            'warna_label'   => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'urutan_tampil' => ['nullable', 'integer', 'min:1', 'max:9999'],
            'is_aktif'      => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Kategori dengan nama ini sudah ada.',
            'warna_label.regex'      => 'Warna label harus berupa kode hex valid, contoh: #6f42c1.',
        ];
    }
}
