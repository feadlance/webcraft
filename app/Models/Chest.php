<?php

namespace Webcraft\Models;

use Illuminate\Database\Eloquent\Model;

class Chest extends Model
{
	protected $table = 'chests';

	protected $fillable = [
		'username',
		'number',
		'inventory',
		'opened'
	];

	public $timestamps = false;

	public function user()
	{
		return $this->belongsTo('Webcraft\Models\User', 'username', 'username')->first();
	}
}