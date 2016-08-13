<?php

namespace Webcraft\Http\Controllers;

use DB;
use Config;
use Webcraft\Models\User;
use Webcraft\Models\Stats3\Pvp;

class ProfileController extends Controller
{
	public function getIndex($player)
	{
		$user = User::where('username', $player)->first();

		if ( $user === null ) {
			return abort(404);
		}

		$statuses = $user->getProfileStatuses()->orderBy('id', 'desc')->get();

		return view('profile.index')
			->with('user', $user)
			->with('statuses', $statuses);
	}

	public function getDetailKill($player)
	{
		$user = User::where('username', $player)->first();

		if ( $user === null ) {
			return abort(404);
		}

		$killed_users = $user->game()
			->detailPlayerKills()
			->select('victim', DB::raw('count(*) as total'))
			->orderBy('value', 'desc')
			->groupBy('victim')
			->get();

		$killed_monsters = $user->game()
			->playerKills('MONSTERS')
			->orderBy('value', 'desc')
			->get();

		$killed_animals = $user->game()
			->playerKills('ANIMALS')
			->orderBy('value', 'desc')
			->get();

		return view('profile.killed')
				->with('user', $user)
				->with('killed_users', $killed_users)
				->with('killed_monsters', $killed_monsters)
				->with('killed_animals', $killed_animals);
	}

	public function getDetailDeath($player)
	{
		$user = User::where('username', $player)->first();

		if ( $user === null ) {
			return abort(404);
		}

		$from_players = $user->game()
			->detailPlayerKills('victim')
			->select('uuid', DB::raw('count(*) as total'))
			->orderBy('value', 'desc')
			->groupBy('uuid')
			->get();

		$from_monsters = $user->game()
			->playerDeaths('MONSTERS')
			->orderBy('value', 'desc')
			->get();

		$from_others = $user->game()
			->playerDeaths('OTHERS')
			->orderBy('value', 'desc')
			->get();

		return view('profile.death')
			->with('user', $user)
			->with('from_players', $from_players)
			->with('from_monsters', $from_monsters)
			->with('from_others', $from_others);
	}
}