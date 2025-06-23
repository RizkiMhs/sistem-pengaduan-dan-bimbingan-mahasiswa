<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dosenpa;

class Rating extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        // Filter berdasarkan parameter pencarian 'cari'
        $query->when($filters['cari'] ?? false, function ($query, $cari) {
            return $query->whereHas('dosenpa', function ($query) use ($cari) {
                $query->where('nama', 'like', '%' . $cari . '%');
            })->orWhereHas('mahasiswa', function ($query) use ($cari) {
                $query->where('nama', 'like', '%' . $cari . '%');
            });
        });

        // filter berdasarkan tanggal start dan end
        $query->when(isset($filters['start']) && isset($filters['end']), function ($query) use ($filters) {
            return $query->whereBetween('created_at', [$filters['start'], $filters['end']]);
        });
    }

    public function dosenpa()
    {
        return $this->belongsTo(Dosenpa::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
