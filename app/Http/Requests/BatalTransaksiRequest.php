<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * BatalTransaksiRequest
 *
 * Validasi alasan pembatalan transaksi (Bagian 6.4 rancangan arsitektur:
 * "Admin wajib mengisi alasan pembatalan sebelum konfirmasi bisa dilakukan").
 */
class BatalTransaksiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'alasan_batal' => ['required', 'string', 'min:5', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'alasan_batal.required' => 'Alasan pembatalan wajib diisi.',
            'alasan_batal.min'      => 'Alasan pembatalan minimal 5 karakter, mohon jelaskan dengan cukup detail.',
        ];
    }
}
