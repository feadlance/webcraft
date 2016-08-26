<?php

namespace Webcraft\Http\Controllers;

use Auth;
use Webcraft\Models\User;
use Webcraft\Models\Stats3\Kill;

class HomeController extends Controller
{
	public function getIndex()
	{
		$user = Auth::user();
		$online_users = User::where('isLogged', 1)->orderBy('id', 'desc')->limit(5)->get();
		$top5_users = Kill::where('entityType', 'PLAYER')->orderBy('value', 'desc')->limit(5)->get();
		$statuses = $user->getHomeStatuses()->orderBy('id', 'desc')->get();

		return view(app('template') . '.home')
			->with('user', $user)
			->with('online_users', $online_users)
			->with('top5_users', $top5_users)
			->with('statuses', $statuses);
	}
}
