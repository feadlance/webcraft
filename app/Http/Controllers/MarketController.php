<?php

namespace Webcraft\Http\Controllers;

use Illuminate\Http\Request;
use Webcraft\Helpers\Minecraft\Materials\Material;

class MarketController extends Controller
{
	public function getIndex()
	{
		dd(Material::find('WOOD', 3));
		dd();
		return view(app('template') . '.market.index');
	}
}