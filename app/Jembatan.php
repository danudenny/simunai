<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Kecamatan;
use App\Jalan;

class Jembatan extends Model
{
    use HasFactory;

    protected $table = 'jembatan';

    protected $fillable = [
        'nama_jembatan',
        'panjang',
        'lebar',
        'panjang',
        'elevasi',
        'lat',
        'long',
        'tipe_lintasan',
        'kondisi_jembatan',
        'tipe_pondasi',
        "kecamatan_id",
        "ruas_jalan_id",
        "foto",
        "video"
    ];

    public function kecamatan() {
        return $this->belongsTo(Kecamatan::class);
    }

    public function jalan() {
        return $this->belongsTo(Jalan::class);
    }
}
