<?php

namespace Webcraft\Models;

use Illuminate\Database\Eloquent\Model;

class Chest extends Model
{
	protected $table = 'chests';

	protected $fillable = [
		'uuid',
		'number',
		'inventory'
	];

	public function user()
	{
		return $this->belongsTo('Webcraft\Models\User', 'uuid', 'username')->first();
	}
}