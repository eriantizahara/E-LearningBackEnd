<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Matakuliah extends Model
{
    use HasFactory;
    protected $table = "matakuliahs";
    protected $primaryKey = 'kode_matakuliah';
    public $incrementing = false; // jangan auto increment
    protected $keyType = 'string'; // primary key tipe string
    protected $fillable = [
        'kode_matakuliah',
        'nama_matakuliah',
        'sks',
        'semester',
    ];

    public $timestamps = true;
}
