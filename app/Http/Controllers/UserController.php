<?php

namespace Webcraft\Http\Controllers;

use Webcraft\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
	public function getUsers(Request $request)
	{
		$filter = $request->input('filtrele');

		$users = User::orderBy('lastlogin', 'desc')->where('id', '!=', \Auth::id());

		if ( $filter === 'oyunda' ) {
			$users = $users->where('isLogged', 1);
		}

		return view('user.index')
			->with('users', $users->get());
	}
}