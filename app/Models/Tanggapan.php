<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Tanggapan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        // Filter berdasarkan parameter pencarian 'cari'
        $query->when($filters['cari'] ?? false, function ($query, $cari) {
            return $query->whereHas('dosenpa', function ($query) use ($cari) {
                $query->where('nama', 'like', '%' . $cari . '%');
            })->orWhereHas('pengaduan', function ($query) use ($cari) {
                $query->whereHas('mahasiswa', function ($query) use ($cari) {
                    $query->where('nama', 'like', '%' . $cari . '%');
                });
            });
        });
    
        // filter berdasarkan tanggal start dan end
        $query->when(isset($filters['start']) && isset($filters['end']), function ($query) use ($filters) {
            return $query->whereBetween('created_at', [$filters['start'], $filters['end']]);
        });
        
    }

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function dosenpa()
    {
        return $this->belongsTo(Dosenpa::class);
    }
}
