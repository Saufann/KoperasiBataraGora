<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {

            $table->id();

            $table->string('kode')->unique();

            $table->string('nama_peminjam');

            $table->decimal('jumlah', 15, 2);

            $table->integer('tenor');

            $table->enum('status', [
                'MENUNGGU',
                'DISETUJUI',
                'DITOLAK',
                'LUNAS'
            ])->default('MENUNGGU');

            $table->text('catatan_admin')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
