<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Loan extends Model
{
    protected $fillable = [
        'kode',
        'nama_peminjam',
        'jumlah',
        'tenor',
        'status',
        'catatan_admin'
    ];

    /**
     * Relasi ke User (peminjam)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'nama_peminjam', 'nama');
    }
}
