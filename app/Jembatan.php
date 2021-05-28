<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jembatan extends Model
{
    use HasFactory;

    protected $table = 'jembatan';

    protected $fillable = [
        'nama_jembatan',
        'kondisi_jembatan',
        'status_jembatan',
        'panjang',
        'lebar',
        'jenis_perkerasan',
        'kelas_jembatan',
        'geojson',
        'style',
        'kecamatan_id',
        "created_at",
        "updated_at"
    ];

    public function kecamatan() {
        return $this->belongsTo(Kecamatan::class);
    }
}
