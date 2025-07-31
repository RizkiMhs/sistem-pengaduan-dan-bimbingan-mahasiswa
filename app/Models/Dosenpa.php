<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosenpa extends Model
{
    use HasFactory;

 

    protected $guarded = ['id'];
    protected $hidden = [
        'password',
    ];

    public function scopeFilter($query, array $filters)
    {
        // Filter berdasarkan parameter pencarian 'cari'
        $query->when($filters['cari'] ?? false, function ($query, $cari) {
            return $query->where('nama', 'like', '%' . $cari . '%');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class);
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }

    public function jadwalBimbingan()
    {
        return $this->hasMany(JadwalBimbingan::class, 'dosenpa_id');
    }

    public function prodi()
    {
        return $this->belongsTo(\App\Models\Prodi::class);
    }

}
