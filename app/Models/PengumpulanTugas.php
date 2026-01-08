<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    use HasFactory;

    protected $table = 'pengumpulan_tugas';
    protected $primaryKey = 'id';

    // Mass assignable
    protected $fillable = [
        'tugas_kode',
        'mahasiswa_nobp',
        'upload_file_jawaban',
        'nilai',
    ];

    /**
     * Relasi ke Tugas
     * Satu pengumpulan milik satu tugas
     */
    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_kode', 'kode_tugas');
    }

    /**
     * Relasi ke Mahasiswa
     * Satu pengumpulan milik satu mahasiswa
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_nobp', 'nobp');
    }
}
