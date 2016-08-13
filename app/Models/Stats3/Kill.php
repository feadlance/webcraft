<?php

namespace Webcraft\Models\Stats3;

use Illuminate\Database\Eloquent\Model;

class Kill extends Model
{
	protected $table = 'stats3_kill';

	public function user()
	{
		return $this->belongsTo('Webcraft\Models\Stats3\Player', 'uuid', 'uuid')->first()->getUser();
	}
}