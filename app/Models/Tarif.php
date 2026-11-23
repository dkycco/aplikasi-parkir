<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tarif extends Model
{
    use HasFactory;

    protected $table = 'tarif';

    protected $fillable = [
        'jenis_kendaraan',
        'tarif_perjam'
    ];
}
