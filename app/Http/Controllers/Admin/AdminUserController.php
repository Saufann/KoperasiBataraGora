<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class AdminUserController extends Controller
{
    /**
     * Tampilkan semua admin
     */
    public function index()
    {
        return view('admin.data-admin', [
            'admins' => AdminUser::latest()->get(),
            'adminName' => session('admin_name', 'Admin')
        ]);
    }

    /**
     * Tambah admin baru
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:100|unique:admin_users,username',
            'password' => 'required|string|min:6',
            'role' => 'required|in:Admin,Super Admin',
            'status' => 'required|in:AKTIF,NONAKTIF'
        ]);

        // hash password
        $data['password'] = Hash::make($data['password']);

        AdminUser::create($data);

        return back()->with('success', 'Admin berhasil ditambahkan');
    }

    /**
     * Update admin
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $admin = AdminUser::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'role' => 'required|in:Admin,Super Admin',
            'status' => 'required|in:AKTIF,NONAKTIF'
        ]);

        $admin->update($data);

        return back()->with('success', 'Data admin diperbarui');
    }

    /**
     * Hapus admin
     */
    public function destroy($id): RedirectResponse
    {
        AdminUser::findOrFail($id)->delete();

        return back()->with('success', 'Admin dihapus');
    }

    /**
     * Reset password admin
     */
    public function resetPassword($id): RedirectResponse
    {
        $admin = AdminUser::findOrFail($id);

        $newPassword = 'admin123';

        $admin->update([
            'password' => Hash::make($newPassword)
        ]);

        return back()->with(
            'success',
            "Password {$admin->username} direset ke: admin123"
        );
    }
}
