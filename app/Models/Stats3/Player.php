<?php

namespace Webcraft\Models\Stats3;

use Config;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
	protected $table = 'stats3_players';

	public function getUser()
	{
		return $this->belongsTo('Webcraft\Models\User', 'name', 'username')->first();
	}

	public function playerKills($type, $sum = false, $table = 'Kill', $column = 'entityType')
	{
		$kills = $this->belongsTo('Webcraft\Models\Stats3\\' . $table, 'uuid', 'uuid');

		if ( $type === 'ALL' ) {
			return $sum === true ? $kills->sum('value') : $kills;
		}

		if ( Config::has('minecraft.mobs.' . $type) ) {
			$kills = $kills->whereIn($column, Config::get('minecraft.mobs.' . $type));
		} else {
			$kills = $kills->where($column, $type);
		}

		return $sum === true ? $kills->sum('value') : $kills;
	}

	public function playerDeaths($type, $sum = false)
	{
		return $this->playerKills($type, $sum, 'Death', 'cause');
	}

	public function detailPlayerKills($column = 'uuid')
	{
		return $this->belongsTo('Webcraft\Models\Stats3\Pvp', 'uuid', $column);
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