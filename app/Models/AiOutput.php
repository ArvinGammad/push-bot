<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiOutput extends Model
{
	use HasFactory;

	protected $fillable = [
		'user_id',
		'input',
		'output',
		'type',
		'charge',
	];

	protected $table = 'ai_outputs';
}
