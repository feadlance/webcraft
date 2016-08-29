<?php

namespace Webcraft\Http\Controllers;

use Auth;
use Carbon\Carbon;

class AccountController extends Controller
{
	public function getAccount()
	{
		$statuses = Auth::user()->getProfileStatuses()->orderBy('id', 'desc')->get();

		return view(app('template') . '.profile.index')
			->with('can_post', true)
			->with('statuses', $statuses)
			->with('user', Auth::user());
	}

	public function getNotifications()
	{
		return view(app('template') . '.account.notifications');
	}
}