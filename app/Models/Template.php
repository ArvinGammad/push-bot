<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
	use HasFactory;

	protected $fillable = [
		'id',
		'name',
		'description',
		'input_fields',
		'icon',
		'endpoint',
		'category_id',
		'slug',
		'status',
		'sample'
	];

	protected $table = 'templates';
}
