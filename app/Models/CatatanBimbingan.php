<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanBimbingan extends Model
{
    use HasFactory;
    protected $table = 'catatan_bimbingans';
    protected $guarded = ['id'];
    
    public function pendaftaranBimbingan()
    {
        return $this->belongsTo(PendaftaranBimbingan::class, 'pendaftaran_id');
    }
}
