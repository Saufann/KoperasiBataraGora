<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AdminUser extends Model
{
    // UBAH BARIS INI: Ganti 'admin_users' menjadi 'users'
    protected $table = 'users';

    protected $fillable = [
        'name',
        'username',
        'password',
        'role',     // Pastikan kolom 'role' ada di tabel users kamu
        'status'    // Pastikan kolom 'status' juga ada di tabel users
    ];

    protected $hidden = [
        'password'
    ];

    /**
     * Otomatis hash password saat disimpan
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }
}