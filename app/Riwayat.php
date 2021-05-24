<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Jalan;
use App\Kontraktor;

class Riwayat extends Model
{
    use HasFactory;
    protected $table = 'riwayat';

    protected $fillable = [
        'jalan_id',
        'tahun',
        'kegiatan',
        'nilai',
        'kontraktor_id',
        'sumber_dana',
        'status'
    ];

    public function jalan() {
        return $this->belongsTo(Jalan::class);
    }

    public function kontraktor() {
        return $this->belongsTo(Kontraktor::class);
    }
}
