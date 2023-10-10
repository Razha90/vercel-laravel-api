<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    protected $primaryKey = 'nim';
    protected $table = 'dosen';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'nim',
        'nama',
        'kontak',
        'email',
        'bidang_studi'
    ];

    public function mahasiswa(){
        return $this->belongsToMany(mahasiswa::class, 'dosen_pembimbing', 'id_dosen', 'id_mahasiswa');
    }

    public function matakuliah() {
        return $this->hasMany(Matakuliah::class, 'id_dosen');
    }
}

