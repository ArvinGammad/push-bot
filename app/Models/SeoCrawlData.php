<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoCrawlData extends Model
{
	use HasFactory;
	protected $fillable = [
        'seo_id',
        'url',
        'content',
        'nlp',
        'terms',
        'headings',
        'titles',
        'words',
        'images',
        'status',
    ];

    protected $table = 'seo_crawl_data';
}
