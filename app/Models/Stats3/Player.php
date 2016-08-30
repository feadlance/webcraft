<?php

namespace Webcraft\Models\Stats3;

use Config;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
	protected $table = 'stats3_players';

	/*
	* Attributes
	*/

	public function getPointAttribute()
	{
		$point = $this->playerKills('PLAYER', true) * 2;
		$point = ($this->playerKills('MONSTERS', true) * 0.5) + $point;
		$point = ($this->playTime() / 900) + $point;

		$point = $point - ($this->playerDeaths('PLAYER', true) * 3);
		$point = $point - ($this->playerDeaths('OTHERS', true) * 0.5);
		$point = $point - $this->playerDeaths('MONSTERS', true);

		if ( $point < 0 ) {
			$point = 0;
		}

		return number_format($point, 2);
	}

	/*
	* Others
	*/

	public function getUser()
	{
		return $this->belongsTo('Webcraft\Models\User', 'name', 'username')->first();
	}

	public function playerKills($type, $sum = false, $table = 'Kill', $column = 'entityType')
	{
		$kills = $this->belongsTo('Webcraft\Models\Stats3\\' . $table, 'uuid', 'uuid');

		if ( $type === 'ALL' ) {
			return $sum === true ? $kills->sum('value') ?: 0 : $kills;
		}

		if ( Config::has('minecraft.mobs.' . $type) ) {
			$kills = $kills->whereIn($column, Config::get('minecraft.mobs.' . $type));
		} else {
			$kills = $kills->where($column, $type);
		}

		return $sum === true ? $kills->sum('value') ?: 0 : $kills;
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
		return $this->belongsTo('Webcraft\Models\Stats3\Playtime', 'uuid', 'uuid')->first()->value ?: 0;
	}

	public function totalJoin()
	{
		return $this->belongsTo('Webcraft\Models\Stats3\Join', 'uuid', 'uuid')->first()->value ?: 0;
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