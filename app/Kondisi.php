<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Jalan;

class Kondisi extends Model
{
    use HasFactory;

    protected $table = 'kondisi_jalan';

    protected $fillable = [
        'baik',
        'sedang',
        'rusak_ringan',
        'rusak_berat',
        'mantap',
        'tidak_mantap'
    ];

    public function jalan() {
        return $this->belongsTo(Jalan::class);
    }
}
