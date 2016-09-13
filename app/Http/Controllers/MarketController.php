<?php

namespace Webcraft\Http\Controllers;

use DB;
use Webcraft\Models\Community_Market;
use Illuminate\Http\Request;

class MarketController extends Controller
{
	public function getIndex()
	{
		$materials = Community_Market::groupBy('type', 'meta')->get();

		return view(app('template') . '.market.community.index')
			->with('materials', $materials);
	}
}