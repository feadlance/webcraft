<?php

namespace Webcraft\Http\Controllers;

use Webcraft\Models\Stats3\Kill;
use Webcraft\Models\User;

class HomeController extends Controller
{
	public function getIndex()
	{
		$user = \Auth::user();
		$online_users = User::where('isLogged', 1)->orderBy('id', 'desc')->limit(6)->get();
		$top5_users = Kill::where('entityType', 'PLAYER')->orderBy('value', 'desc')->limit(5)->get();
		$statuses = $user->getHomeStatuses()->orderBy('id', 'desc')->get();

		return view('home')
			->with('user', $user)
			->with('online_users', $online_users)
			->with('top5_users', $top5_users)
			->with('statuses', $statuses);
	}
}
