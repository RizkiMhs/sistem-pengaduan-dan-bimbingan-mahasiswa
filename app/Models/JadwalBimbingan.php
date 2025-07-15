<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Dosenpa;
use App\Models\KategoriBimbingan;
use App\Models\PendaftaranBimbingan;

class JadwalBimbingan extends Model
{
    use HasFactory;
    protected $table = 'jadwal_bimbingans';
    protected $guarded = ['id'];
    public function dosenpa()
    {
        return $this->belongsTo(Dosenpa::class, 'dosenpa_id');
    }
    public function kategoriBimbingan()
    {
        return $this->belongsTo(KategoriBimbingan::class, 'kategori_bimbingan_id');
    }

    public function pendaftaranBimbingan(): HasMany
    {
        // Pastikan Anda sudah punya model PendaftaranBimbingan
        return $this->hasMany(PendaftaranBimbingan::class);
    }
}
