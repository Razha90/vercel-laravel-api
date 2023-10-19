<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah_Mahasiswa extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'matakuliah_mahasiswa';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'id_mahasiswa',
        'id_matakuliah'
    ];
}
