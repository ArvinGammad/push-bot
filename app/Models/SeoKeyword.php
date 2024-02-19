<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoKeyword extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'keywords',
        'status',
    ];

    protected $table = 'seo_keywords';
}
