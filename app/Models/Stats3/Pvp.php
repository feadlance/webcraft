<?php

namespace Webcraft\Models\Stats3;

use Illuminate\Database\Eloquent\Model;

class Pvp extends Model
{
	protected $table = 'stats3_pvp';

	public function victim()
	{
		return $this->belongsTo('Webcraft\Models\Stats3\Player', 'victim', 'uuid')->first()->getUser();
	}

	public function user()
	{
		return $this->belongsTo('Webcraft\Models\Stats3\Player', 'uuid', 'uuid')->first()->getUser();
	}
}