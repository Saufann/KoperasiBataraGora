<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Tampilkan semua user
     */
    public function index()
    {
        return view('admin.users', [
            'users' => User::latest()->get(),
            'adminName' => session('admin_name', 'Admin')
        ]);
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => 'required|string|max:100',
            'nip' => 'required|string|max:50|unique:users,nip',
            'unit_kerja' => 'required|string|max:100',
            'gaji' => 'required|integer|min:0',
            'status' => 'required|in:Aktif,Nonaktif'
        ]);

        User::create($data);

        return back()->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Detail user (JSON)
     */
    public function show($id): JsonResponse
    {
        $user = User::with(['loans', 'orders'])->findOrFail($id);

        return response()->json($user);
    }

    /**
     * Ambil orders user
     */
    public function orders($id): JsonResponse
    {
        $user = User::with('orders')->findOrFail($id);

        return response()->json($user->orders);
    }

    /**
     * Update user
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string|max:100',
            'unit_kerja' => 'required|string|max:100',
            'gaji' => 'required|integer|min:0',
            'status' => 'required|in:Aktif,Nonaktif'
        ]);

        $user->update($data);

        return back()->with('success', 'User diperbarui');
    }

    /**
     * Hapus user
     */
    public function destroy($id): RedirectResponse
    {
        User::findOrFail($id)->delete();

        return back()->with('success', 'User dihapus');
    }

    /**
     * Auto deactivate user jika pinjaman lewat jatuh tempo
     */
    public function autoDeactivateUsers(): void
    {
        $users = User::whereHas('loans', function ($q) {
            $q->where('status', 'DISETUJUI')
              ->whereDate('jatuh_tempo', '<', now());
        })->get();

        foreach ($users as $user) {
            $user->update([
                'status' => 'Nonaktif'
            ]);
        }
    }
}
