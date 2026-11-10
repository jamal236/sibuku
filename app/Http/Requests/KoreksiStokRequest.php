<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * KoreksiStokRequest
 *
 * Validasi input koreksi stok manual (Bagian 6.3 rancangan arsitektur:
 * "Alur Koreksi Stok"). Alasan koreksi WAJIB diisi untuk keperluan
 * audit trail di tabel riwayat_stok.
 */
class KoreksiStokRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'stok_aktual' => ['required', 'integer', 'min:0'],
            'alasan'      => ['required', 'string', 'min:5', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'stok_aktual.required' => 'Jumlah stok aktual hasil perhitungan fisik wajib diisi.',
            'stok_aktual.min'      => 'Jumlah stok aktual tidak boleh negatif.',
            'alasan.required'      => 'Alasan koreksi wajib diisi untuk keperluan audit.',
            'alasan.min'           => 'Alasan koreksi minimal 5 karakter, mohon jelaskan dengan cukup detail.',
        ];
    }
}
