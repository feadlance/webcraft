<?php

namespace Webcraft\Models\Stats3;

use Config;
use Illuminate\Database\Eloquent\Model;

class Death extends Model
{
	protected $table = 'stats3_death';

	public function getMobAvatar($size = 100)
	{
		$mobs = Config::get('minecraft.mobs');

		if ( !in_array($this->cause, $mobs['MONSTERS']) && !in_array($this->cause, $mobs['ANIMALS']) ) {
			return false;
		}

		$cause = $this->cause;

		switch ($cause) {
			case 'PIG_ZOMBIE':
				$cause = 'PIG';
				break;
		}
		
		return 'https://minotar.net/avatar/MHF_' . $cause . '/' . $size . '.png';
	}
}