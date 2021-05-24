<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanWarga extends Model
{
    use HasFactory;
    protected $table = 'laporan_warga';

    protected $fillable = [
        'nama',
        'email',
        'phone',
        'description',
        'foto',
        'jalan_id'
    ];

    public function jalan() {
        return $this->belongsTo(Jalan::class);
    }
}
