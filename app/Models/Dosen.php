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
        'nama',
        'kontak',
        'email',
    ];

    public function mahasiswa(){
        return $this->belongsToMany(mahasiswa::class, 'dosen_pembimbing', 'id_dosen', 'id_mahasiswa');
    }

    public function matakuliah() {
        return $this->belongsToMany(Matakuliah::class, 'dosen_matakuliah', 'id_dosen', 'id_matakuliah');
    }
}

