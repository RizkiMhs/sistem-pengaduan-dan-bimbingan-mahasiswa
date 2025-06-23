<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBimbingan extends Model
{
    use HasFactory;
    protected $table = 'kategori_bimbingans';
    protected $guarded = ['id'];

    public function jadwalBimbingans()
    {
        return $this->hasMany(JadwalBimbingan::class, 'kategori_bimbingan_id');
    }
}
