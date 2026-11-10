<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:supplier,donatur',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string|max:1000',
            'keterangan' => 'nullable|string|max:1000',
            'is_aktif' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama supplier/donatur wajib diisi.',
            'jenis.required' => 'Jenis wajib dipilih.',
            'jenis.in' => 'Pilihan jenis tidak valid.',
            'email.email' => 'Format email tidak valid.',
        ];
    }
}