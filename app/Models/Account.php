<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $table = 'account';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'password',
        'email'
    ];
    protected $casts = [
        'password' => 'hashed'
    ];
    protected $hidden = [
        "password"
    ];
}
