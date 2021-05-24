<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Jalan;

class Lampiran extends Model
{
    use HasFactory;
    protected $table = 'lampiran';

    protected $fillable = [
        'jalan_id',
        'file_name',
        'url',
        'is_video'
    ];

    public function jalan() {
        return $this->belongsTo(Jalan::class);
    }
}
