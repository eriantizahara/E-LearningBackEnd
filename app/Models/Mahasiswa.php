<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = "mahasiswas";
    protected $primaryKey = 'nobp';
    public $incrementing = false; // jangan auto increment
    protected $keyType = 'string'; // primary key tipe string
    protected $fillable = [
        'nobp',
        'nama_lengkap',
        'user_id',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'prodi',
        'angkatan',
        'status',
    ];

    public $timestamps = true;

    // RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function krs()
    {
        return $this->hasOne(
            Krs::class,
            'mahasiswa_nobp',
            'nobp'
        );
    }
}
