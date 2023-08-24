<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
	use HasFactory;

	protected $fillable = [
		'user_id',
		'title',
		'description',
		'content',
		'status',
		'type'
	];

	protected $table = 'articles';
}
