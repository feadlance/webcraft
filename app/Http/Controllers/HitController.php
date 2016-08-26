<?php

namespace Webcraft\Http\Controllers;

use Webcraft\Models\Stats3\Player;

class HitController extends Controller
{
	public function getBest100()
	{
		$bestUsers = Player::limit(100)->get()->sortByDesc('point');

		return view(app('template') . '.top.best')
			->with('bestUsers', $bestUsers);
	}
}