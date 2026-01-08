<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class KRS extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'krs';

    // Primary key custom
    protected $primaryKey = 'kode_krs';

    // PK bukan auto increment
    public $incrementing = false;

    // Tipe PK string
    protected $keyType = 'string';

    // Field yang boleh diisi
    protected $fillable = [
        'kode_krs',
        'mahasiswa_nobp',
        'status',
    ];

    /**
     * Relasi ke Mahasiswa
     * KRS milik satu mahasiswa
     */
    public function mahasiswa()
    {
        return $this->belongsTo(
            Mahasiswa::class,
            'mahasiswa_nobp',
            'nobp'
        );
    }

    /**
     * Relasi ke Detail KRS
     * Satu KRS punya banyak mata kuliah
     */
    public function detailKrs()
    {
        return $this->hasMany(
            DetailKrs::class,
            'krs_kode',
            'kode_krs'
        );
    }
}
