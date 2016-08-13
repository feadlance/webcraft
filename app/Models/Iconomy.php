<?php

namespace Webcraft\Models;

use Illuminate\Database\Eloquent\Model;

class Iconomy extends Model
{
	protected $table = 'iconomy';

	protected $fillable = [
		'username',
		'balance',
		'status'
	];

	public $timestamps = false;
}