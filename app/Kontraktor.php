<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontraktor extends Model
{
    use HasFactory;

    protected $table = 'kontraktor';

    protected $fillable = [
        'nama',
        'alamat',
        'email',
        'telepon',
        'is_active'
    ];

}
