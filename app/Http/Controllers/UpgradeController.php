<?php

namespace Webcraft\Http\Controllers;

use Webcraft\Models\Group;

class UpgradeController extends Controller
{
	public function getIndex()
	{
		$groups = Group::orderBy('money', 'desc')->get();

		return view(app('template') . '.upgrade.index')
			->with('groups', $groups);
	}
}