<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * UserController
 *
 * Mengelola akun pengguna dan role (Bagian 5.1: hak akses Admin
 * "Mengelola seluruh user dan role", "Menambah, mengedit, menonaktifkan,
 * dan mereset password akun pengguna lain").
 *
 * Hak akses: hanya admin (permission 'user.kelola').
 *
 * Catatan keamanan: akun tidak pernah dihapus secara permanen dari
 * sistem ini. Penghapusan dilakukan dengan menonaktifkan akun
 * (is_aktif = false), sehingga riwayat transaksi yang dibuat oleh
 * pengguna tersebut (kolom user_id pada tabel transaksi, dengan
 * foreign key RESTRICT) tetap terjaga.
 */
class UserController extends Controller
{
    /**
     * Daftar seluruh pengguna beserta role-nya.
     */
    public function index(): View
    {
        $users = User::with('roles')
            ->orderBy('name')
            ->paginate(20);

        return view('user.index', compact('users'));
    }

    /**
     * Form tambah pengguna baru.
     */
    public function create(): View
    {
        return view('user.create');
    }

    /**
     * Simpan pengguna baru beserta penetapan role-nya.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'is_aktif' => $request->boolean('is_aktif', true),
        ]);

        $user->assignRole($data['role']);

        return redirect()
            ->route('user.index')
            ->with('success', "Akun '{$user->name}' dengan role '{$data['role']}' berhasil dibuat.");
    }

    /**
     * Form edit pengguna.
     */
    public function edit(User $user): View
    {
        $currentRole = $user->roles->first()?->name;

        return view('user.edit', compact('user', 'currentRole'));
    }

    /**
     * Perbarui data pengguna.
     *
     * Password hanya diperbarui jika field 'password' diisi (tidak
     * kosong). Jika dikosongkan, password lama dipertahankan.
     *
     * Catatan keamanan tambahan: admin tidak diperbolehkan menonaktifkan
     * akunnya sendiri atau mengubah role dirinya sendiri menjadi
     * non-admin, untuk mencegah situasi "terkunci" tanpa akses admin
     * sama sekali ke sistem.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        $isSelf = $user->id === Auth::id();

        if ($isSelf && $data['role'] !== 'admin') {
            return redirect()
                ->route('user.edit', $user)
                ->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri menjadi selain admin.');
        }

        if ($isSelf && !$request->boolean('is_aktif', true)) {
            return redirect()
                ->route('user.edit', $user)
                ->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $updateData = [
            'name'     => $data['name'],
            'email'    => $data['email'],
            'is_aktif' => $request->boolean('is_aktif', true),
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);
        $user->syncRoles([$data['role']]);

        return redirect()
            ->route('user.index')
            ->with('success', "Akun '{$user->name}' berhasil diperbarui.");
    }

    /**
     * Nonaktifkan akun pengguna (bukan hapus permanen — lihat catatan
     * keamanan di atas kelas).
     *
     * Admin tidak dapat menonaktifkan akunnya sendiri.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return redirect()
                ->route('user.index')
                ->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $user->update(['is_aktif' => false]);

        return redirect()
            ->route('user.index')
            ->with('success', "Akun '{$user->name}' berhasil dinonaktifkan.");
    }

    /**
     * Aktifkan kembali akun pengguna yang sebelumnya dinonaktifkan.
     */
    public function aktifkan(User $user): RedirectResponse
    {
        $user->update(['is_aktif' => true]);

        return redirect()
            ->route('user.index')
            ->with('success', "Akun '{$user->name}' berhasil diaktifkan kembali.");
    }
}
