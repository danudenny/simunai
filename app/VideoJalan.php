<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoJalan extends Model
{
    use HasFactory;

    protected $table = "video_jalan";

    protected $fillable = [
      'jalan_id',
      'url'
    ];
}
