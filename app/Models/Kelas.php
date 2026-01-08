<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'kelas';

    // Primary Key
    protected $primaryKey = 'kode_kelas';

    // PK bukan auto increment
    public $incrementing = false;

    // Tipe PK adalah string
    protected $keyType = 'string';

    // Kolom yang boleh diisi
    protected $fillable = [
        'kode_kelas',
        'matakuliah_kode',
        'dosen_nidn',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruang',
        'kapasitas',
    ];

    /* =====================
       RELATIONSHIPS
       ===================== */

    // Relasi ke Matakuliah
    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_kode', 'kode_matakuliah');
    }

    // Relasi ke Dosen
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_nidn', 'nidn');
    }
}
