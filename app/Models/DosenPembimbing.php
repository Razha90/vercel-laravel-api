<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenPembimbing extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'dosen_pembimbing';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'id_dosen',
        'id_mahasiswa'
    ];
}
