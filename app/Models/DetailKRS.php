<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class DetailKRS extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'detail_krs';

    // Field yang boleh diisi
    protected $fillable = [
        'krs_kode',
        'kelas_kode',
    ];

    /**
     * Relasi ke KRS
     */
    public function krs()
    {
        return $this->belongsTo(
            Krs::class,
            'krs_kode',
            'kode_krs'
        );
    }

    /**
     * Relasi ke Kelas
     */
    public function kelas()
    {
        return $this->belongsTo(
            Kelas::class,
            'kelas_kode',
            'kode_kelas'
        );
    }
}
