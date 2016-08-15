<?php

namespace Webcraft\Http\Controllers;

use Webcraft\Models\Stats3\Kill;

class HitController extends Controller
{
	public function getTopKillers()
	{
		$top100 = Kill::where('entityType', 'PLAYER')->orderBy('value', 'desc')->limit(100)->get();

		return view('top.killers')
			->with('top100', $top100);
	}
}