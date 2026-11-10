<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Buku;

class UpdateBukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul'             => ['required', 'string', 'max:255'],
            'pengarang'         => ['required', 'string', 'max:255'],
            'penerbit'          => ['nullable', 'string', 'max:255'],
            'tahun_terbit'      => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'isbn'              => ['nullable', 'string', 'max:20'],
            'kategori_id'       => ['required', 'integer', 'exists:kategori,id'],
            'kondisi'           => ['required', 'string', 'in:' . implode(',', array_keys(Buku::KONDISI_LABEL))],
            'deskripsi_kondisi' => ['nullable', 'string'],
            'harga'             => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'stok_minimum'      => ['nullable', 'integer', 'min:0'],
            'lokasi_rak'        => ['nullable', 'string', 'max:50'],
            'foto'              => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_aktif'          => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required'       => 'Judul buku wajib diisi.',
            'pengarang.required'   => 'Nama pengarang wajib diisi.',
            'kategori_id.required' => 'Kategori buku wajib dipilih.',
            'kategori_id.exists'   => 'Kategori yang dipilih tidak valid.',
            'kondisi.required'     => 'Kondisi buku wajib dipilih.',
            'kondisi.in'           => 'Kondisi buku tidak valid.',
            'harga.required'       => 'Harga buku wajib diisi.',
            'harga.min'            => 'Harga buku tidak boleh negatif.',
            'foto.image'           => 'File yang diunggah harus berupa gambar.',
            'foto.mimes'           => 'Format foto harus jpg, jpeg, png, atau webp.',
            'foto.max'             => 'Ukuran foto maksimal 2MB.',
        ];
    }
}
