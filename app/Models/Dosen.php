<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dosen extends Model
{
    use HasFactory;
    protected $table = "dosens";
    protected $primaryKey = 'nidn';
    public $incrementing = false; // jangan auto increment
    protected $keyType = 'string'; // primary key tipe string
    protected $fillable = [
        'nidn',
        'nama_lengkap',
        'user_id',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'keahlian',
        'status',
    ];

    public $timestamps = true;

    // RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
