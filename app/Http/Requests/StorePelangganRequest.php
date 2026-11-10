<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * StorePelangganRequest
 *
 * Validasi input data pelanggan (Bagian 2.1: pelanggan/create.blade.php).
 * Digunakan untuk store maupun update — tidak ada perbedaan rule
 * antara keduanya untuk entitas ini, sehingga satu request class cukup.
 */
class StorePelangganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama'          => ['required', 'string', 'max:255'],
            'telepon'       => ['nullable', 'string', 'max:20'],
            'email'         => ['nullable', 'email', 'max:255'],
            'alamat'        => ['nullable', 'string'],
            'tanggal_lahir' => ['nullable', 'date', 'before:today'],
            'catatan'       => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required'         => 'Nama pelanggan wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'tanggal_lahir.date'    => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before'  => 'Tanggal lahir harus sebelum hari ini.',
        ];
    }
}
