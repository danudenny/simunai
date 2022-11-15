<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Kecamatan;

class Jalan extends Model
{
    use HasFactory;

    protected $table = 'jalan';

    protected $fillable = [
        'nama_ruas',
        'kondisi_jalan',
        'status_jalan',
        'panjang',
        'lebar',
        'jenis_perkerasan',
        'kelas_jalan',
        'th_data',
        'style',
        'kecamatan_id',
        "created_at",
        "updated_at",
        'mendukung',
        'uraian_dukungan',
        'titik_pengenal_awal',
        'titik_pengenal_akhir',
        'kode_patok',
        'baik',
        'sedang',
        'rusak_ringan',
        'rusak_berat',
        'geom'
    ];

    public function kecamatan() {
        return $this->belongsTo(Kecamatan::class);
    }

    public function video() {
        return $this->belongsTo(VideoJalan::class);
    }

}
