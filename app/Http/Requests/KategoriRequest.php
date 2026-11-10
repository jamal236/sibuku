<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KategoriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $kategoriId = $this->route('kategori')?->id;

        return [
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategori', 'nama_kategori')->ignore($kategoriId),
            ],
            'deskripsi' => 'nullable|string|max:1000',
            'warna_label' => [
                'required',
                'string',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],
            'urutan_tampil' => 'nullable|integer|min:1|max:999',
            'is_aktif' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah digunakan.',
            'nama_kategori.max' => 'Nama kategori maksimal 255 karakter.',
            'warna_label.required' => 'Warna label wajib diisi.',
            'warna_label.regex' => 'Format warna tidak valid. Gunakan format HEX (contoh: #FF0000).',
            'urutan_tampil.integer' => 'Urutan tampil harus berupa angka.',
        ];
    }
}