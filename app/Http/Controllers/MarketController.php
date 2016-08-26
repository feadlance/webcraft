<?php

namespace Webcraft\Http\Controllers;

use Webcraft\Models\Group;
use Webcraft\Models\Product;

use Illuminate\Http\Request;

class MarketController extends Controller
{
	public function getIndex()
	{
		return view(app('template') . '.market.index');
	}
}