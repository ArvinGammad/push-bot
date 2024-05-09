<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'addon_id',
        'limit',
        'subscription_id',
        'plan_id',
        'credit',
        'seo',
        'image',
        'status',
        'validity'
    ];

    protected $table = 'packages';
}
