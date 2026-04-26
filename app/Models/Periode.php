<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;
    protected $table = 'periode';
    // Guarded kosong artinya semua kolom "aman" untuk diisi sekaligus
    protected $guarded = [];

    /**
     * Opsional: Tetap gunakan casts agar Laravel mengenali 
     * waktu_mulai & waktu_selesai sebagai objek Carbon (Tanggal).
     */
    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }
}
