<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mahasiswa extends Model
{
    use HasFactory;
    protected $primaryKey = 'nim';
    protected $table = 'mahasiswa';
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'nama',
        'kontak',
        'email',
        'alamat'
    ];

    public function dosen(){
        return $this->belongsToMany(Dosen::class, 'dosen_pembimbing', 'id_mahasiswa', 'id_dosen');
    }

    public function matakuliah() {
        return $this->belongsToMany(Matakuliah::class, 'matakuliah_mahasiswa', 'id_matakuliah', "id_mahasiswa");
    }
}