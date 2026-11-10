<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransaksiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'items' => 'required|array|min:1',
            'items.*.buku_id' => 'required|exists:buku,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric|min:0',
            'items.*.diskon' => 'nullable|numeric|min:0',
            'pelanggan_id' => 'nullable|exists:pelanggan,id',
            'diskon' => 'nullable|numeric|min:0',
            'bayar' => 'required|numeric|min:0',
            'metode_bayar' => 'required|in:tunai,transfer,qris',
            'catatan' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Minimal 1 item harus ditambahkan.',
            'items.*.buku_id.exists' => 'Buku tidak valid.',
            'items.*.jumlah.min' => 'Jumlah minimal 1.',
            'bayar.min' => 'Jumlah bayar tidak valid.',
            'metode_bayar.in' => 'Metode pembayaran tidak valid.',
        ];
    }
}