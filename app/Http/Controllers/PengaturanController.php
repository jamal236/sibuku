<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{

    public function index()
    {
        // Ambil semua pengaturan
        $settings = Pengaturan::all()->keyBy('key');
        
        return view('pengaturan.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'toko_nama' => 'required|string|max:255',
            'toko_alamat' => 'required|string|max:255',
            'toko_telepon' => 'nullable|string|max:20',
            'toko_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'nota_pesan' => 'nullable|string|max:255',
            'nota_tampilkan_logo' => 'nullable|boolean',
            'stok_minimum_default' => 'required|integer|min:1',
        ]);

        // Update pengaturan teks/angka
        $textSettings = [
            'toko_nama' => $request->toko_nama,
            'toko_alamat' => $request->toko_alamat,
            'toko_telepon' => $request->toko_telepon,
            'nota_pesan' => $request->nota_pesan,
            'stok_minimum_default' => $request->stok_minimum_default,
        ];

        foreach ($textSettings as $key => $value) {
            // Note: menggunakan key persis seperti di database (ada yang ada spasinya di SQL dump, kita handle di sini)
            $setting = Pengaturan::where('key', $key)->first();
            if ($setting) {
                $setting->update(['value' => $value]);
            }
        }

        // Handle Checkbox (nota_tampilkan_logo)
        $logoSetting = Pengaturan::where('key', 'nota_tampilkan_logo')->first(); // Di DB ada spasi di akhir, tapi Laravel biasanya trim atau kita pakai yang ini
        if (!$logoSetting) {
             $logoSetting = Pengaturan::where('key', 'nota_tampilkan_logo ')->first();
        }
        
        if ($logoSetting) {
            $logoSetting->update(['value' => $request->has('nota_tampilkan_logo') ? '1' : '0']);
        }

        // Handle Upload Logo
        if ($request->hasFile('toko_logo')) {
            $logoSetting = Pengaturan::where('key', 'toko_logo')->first();
            if (!$logoSetting) {
                $logoSetting = Pengaturan::where('key', 'toko_logo')->first();
            }

            // Hapus logo lama jika ada
            if ($logoSetting && $logoSetting->value) {
                Storage::disk('public')->delete($logoSetting->value);
            }

            $path = $request->file('toko_logo')->store('logos', 'public');
            
            if ($logoSetting) {
                $logoSetting->update(['value' => $path]);
            } else {
                Pengaturan::create([
                    'key' => 'toko_logo',
                    'value' => $path,
                    'label' => 'Logo Toko',
                    'group' => 'toko'
                ]);
            }
        }

        return back()->with('success', 'Pengaturan toko berhasil diperbarui!');
    }
}