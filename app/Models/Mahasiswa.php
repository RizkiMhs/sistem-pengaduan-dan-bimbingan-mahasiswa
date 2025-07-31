<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dosenpa()
    {
        return $this->belongsTo(Dosenpa::class);
    }

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class);
    }

    public function tanggapan()
    {
        return $this->hasMany(Tanggapan::class);
    }



    public function tingkat()
    {
        return $this->belongsTo(Tingkat::class);
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
}
