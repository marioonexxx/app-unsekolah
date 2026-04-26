<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skl extends Model
{
    use HasFactory;
    protected $table='skl';

    // Semua kolom boleh diisi mass-assign kecuali id
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}
