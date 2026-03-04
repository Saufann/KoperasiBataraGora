<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Loan;
use App\Models\Order;

class User extends Model
{
    protected $fillable = [
        'nama',
        'nip',
        'unit_kerja',
        'gaji',
        'status'
    ];

    // Relasi ke tabel loans
    public function loans()
    {
        return $this->hasMany(Loan::class, 'nama_peminjam', 'nama');
    }

    // Relasi ke tabel orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
