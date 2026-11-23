<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'id_kendaraan',
        'waktu_masuk',
        'waktu_keluar',
        'id_tarif',
        'durasi',
        'biaya_total',
        'status',
        'id_user',
        'id_area'
    ];

    protected function casts(): array
    {
        return [
            'waktu_masuk'  => 'datetime',
            'waktu_keluar' => 'datetime',
            'durasi'       => 'integer',
            'biaya_total'  => 'decimal:0',
        ];
    }

    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class, 'id_kendaraan');
    }

    public function tarif(): BelongsTo
    {
        return $this->belongsTo(Tarif::class, 'id_tarif');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(AreaParkir::class, 'id_area');
    }
}
