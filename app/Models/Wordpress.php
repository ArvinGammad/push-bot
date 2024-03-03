<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wordpress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'url',
        'username',
        'password',
    ];

    protected $table = 'wordpress';

}
