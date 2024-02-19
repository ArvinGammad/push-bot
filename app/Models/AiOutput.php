<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiOutput extends Model
{
	use HasFactory;

	protected $fillable = [
		'ai_id',
		'user_id',
		'input',
		'output',
		'type',
		'charge',
	];

	protected $table = 'ai_outputs';

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
