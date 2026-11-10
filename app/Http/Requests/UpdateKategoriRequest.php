<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKategoriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $kategoriId = $this->route('kategori')->id;

        return [
            'nama_kategori' => [
                'required', 'string', 'max:255',
                Rule::unique('kategori', 'nama_kategori')->ignore($kategoriId),
            ],
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
