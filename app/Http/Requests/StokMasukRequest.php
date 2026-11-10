<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StokMasukRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->can('stok.catat-masuk');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'buku_id' => 'required|exists:buku,id',
            'supplier_id' => 'required|exists:supplier,id',
            'jumlah' => 'required|integer|min:1',
            'harga_beli' => 'nullable|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:500',
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'buku_id.required' => 'Buku harus dipilih.',
            'buku_id.exists' => 'Buku yang dipilih tidak valid.',
            'supplier_id.required' => 'Supplier/Donatur harus dipilih.',
            'supplier_id.exists' => 'Supplier yang dipilih tidak valid.',
            'jumlah.required' => 'Jumlah buku harus diisi.',
            'jumlah.min' => 'Jumlah minimal 1 buku.',
            'tanggal.required' => 'Tanggal harus diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
        ];
    }
}