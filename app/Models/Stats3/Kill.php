<?php

namespace Webcraft\Models\Stats3;

use Config;
use Illuminate\Database\Eloquent\Model;

class Kill extends Model
{
	protected $table = 'stats3_kill';

	public function user()
	{
		return $this->belongsTo('Webcraft\Models\Stats3\Player', 'uuid', 'uuid')->first()->getUser();
	}

	public function getMobAvatar($size = 100)
	{
		$mobs = Config::get('minecraft.mobs');

		if ( !in_array($this->entityType, $mobs['MONSTERS']) && !in_array($this->entityType, $mobs['ANIMALS']) ) {
			return false;
		}

		$type = $this->entityType;

		switch ($type) {
			case 'PIG_ZOMBIE':
				$type = 'PIG';
				break;
		}
		
		return 'https://minotar.net/avatar/MHF_' . $type . '/' . $size . '.png';
	}
}