<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nip' => ['required', 'string'],
                'password' => ['required', 'string'],
            ],
            [
                'nip.required' => 'NIP wajib diisi.',
                'password.required' => 'Kata sandi wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'login')
                ->withInput($request->only('nip'));
        }

        $user = User::where('nip', $request->nip)->first();

        if (!$user) {
            return back()
                ->withErrors(['nip' => 'NIP tidak terdaftar.'], 'login')
                ->withInput($request->only('nip'));
        }

        if (isset($user->status) && strtolower((string) $user->status) !== 'aktif') {
            return back()
                ->withErrors(['nip' => 'Akun Anda tidak aktif. Hubungi admin.'], 'login')
                ->withInput($request->only('nip'));
        }

        if (!Hash::check((string) $request->password, (string) $user->password)) {
            return back()
                ->withErrors(['password' => 'Kata sandi yang Anda masukkan salah.'], 'login')
                ->withInput($request->only('nip'));
        }

        if (!Auth::attempt(['nip' => $request->nip, 'password' => $request->password])) {
            return back()
                ->withErrors(['login' => 'Login gagal. Silakan coba lagi.'], 'login')
                ->withInput($request->only('nip'));
        }

        $request->session()->regenerate();

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.landing');
    }

    public function logout(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        Auth::logout();

        // Regenerate session ID without flushing cart data.
        $request->session()->regenerate(true);
        $request->session()->regenerateToken();

        if (!empty($cart)) {
            $request->session()->put('cart', $cart);
            $request->session()->save();
        }

        return redirect('/');
    }
}
