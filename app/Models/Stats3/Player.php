<?php

namespace Webcraft\Models\Stats3;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
	protected $table = 'stats3_players';

	public function getUser()
	{
		return $this->belongsTo('Webcraft\Models\User', 'name', 'username')->first();
	}

	public function playerKills($type, $sum = false)
	{
		$kills = $this->belongsTo('Webcraft\Models\Stats3\Kill', 'uuid', 'uuid');

		if ( isset(Kill::getEntityGroups()[$type]) ) {
			$kills = $kills->whereIn('entityType', Kill::getEntityGroups()[$type]);
		} else {
			$kills = $kills->where('entityType', $type);
		}

		return $sum === true ? $kills->sum('value') : $kills;
	}

	public function detailKillPlayers()
	{
		return $this->belongsTo('Webcraft\Models\Stats3\Pvp', 'uuid', 'uuid');
	}

	public function totalDeath()
	{
		return $this->belongsTo('Webcraft\Models\Stats3\Death', 'uuid', 'uuid')->sum('value');
	}

	public function playTime()
	{
		return $this->belongsTo('Webcraft\Models\Stats3\Playtime', 'uuid', 'uuid')->first()->value ?: null;
	}

	public function totalJoin()
	{
		return $this->belongsTo('Webcraft\Models\Stats3\Join', 'uuid', 'uuid')->first()->value ?: null;
	}

	public function lastLogin()
	{
		return $this->online() ? 'online' : $this->getUser()->lastlogin ? Carbon::createFromTimestamp($this->getUser()->lastlogin)->diffForHumans() : 'firstlogin';
	}

	public function online()
	{
		return $this->getUser()->isLogged === 1;
	}
}