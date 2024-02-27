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

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $dateFormat = 'Y-m-d H:i:s';

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('F j, Y \a\t h:iA'); // Change the format as per your requirements
    }
}
