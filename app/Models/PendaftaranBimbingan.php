<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PendaftaranBimbingan extends Model
{
    use HasFactory;
    protected $table = 'pendaftaran_bimbingans';
    protected $guarded = ['id'];
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }
    public function jadwalBimbingan()
    {
        return $this->belongsTo(JadwalBimbingan::class, 'jadwal_bimbingan_id');
    }

    public function catatanBimbingan(): HasOne
    {
        return $this->hasOne(CatatanBimbingan::class, 'pendaftaran_id');
    }
}
