<?php

namespace Webcraft\Http\Controllers;

use DB;
use Webcraft\Models\Stats3\Pvp;
use Webcraft\Models\User;

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
			->detailKillPlayers()
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
}