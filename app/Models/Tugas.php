<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'tugas';
    // Jika primary key bukan 'id'
    protected $primaryKey = 'kode_tugas';
    public $incrementing = false; // karena string, bukan auto-increment
    protected $keyType = 'string';

    // Mass assignable
    protected $fillable = [
        'kode_tugas',
        'kelas_kode',
        'judul',
        'deskripsi',
        'upload_file_tugas',
        'deadline',
    ];

    // RELASI: Tugas belongsTo KRS
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_kode', 'kode_kelas');
    }
}
