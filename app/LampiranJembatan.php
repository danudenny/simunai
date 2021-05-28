<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LampiranJembatan extends Model
{
    use HasFactory;

    protected $table = 'lampiran_jembatan';

    protected $fillable = [
        'jembatan_id',
        'file_name',
        'url',
        'is_video'
    ];
}
