<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    use HasFactory;

    // Nama tabel jika tidak mengikuti konvensi plural
    protected $table = 'moduls';

    // Primary key, default 'id' sudah benar, jadi tidak perlu diubah
    protected $primaryKey = 'id';

    // Mass assignable fields
    protected $fillable = [
        'kelas_kode',
        'judul',
        'file_modul',
    ];

    /**
     * Relasi ke kelas
     * Satu modul dimiliki oleh satu kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_kode', 'kode_kelas');
    }
}
