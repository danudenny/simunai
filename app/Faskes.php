<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faskes extends Model
{
    use HasFactory;

    protected $table = 'kesehatan';

    protected $fillable = [
        'nama_faskes',
        'dokter',
        'dokter_gigi',
        'perawat',
        'bidan',
        'kesehatan_masyarakat',
        'lingkungan_kesehatan',
        'farmasi',
        'gizi',
        'atlm',
        'status',
        'kode',
        'alamat',
        'kecamatan_id',
        'kemampuan_pelayanan',
        'karakteristik_wilayah',
        'geom',
        'type'
    ];

    public function kecamatan() {
        return $this->belongsTo(Kecamatan::class);
    }
}
