<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AreaParkir extends Model
{
    use HasFactory;

    protected $table = 'area_parkir';

    protected $fillable = [
        'nama_area',
        'kapasitas',
        'terisi'
    ];
}
