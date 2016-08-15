<?php

namespace Webcraft\Http\Controllers;

use Webcraft\Models\Group;
use Webcraft\Helpers\Minecraft\Color;

class UpgradeController extends Controller
{
	public function getIndex()
	{
		$groups = Group::orderBy('money', 'desc')->get();

		return view('upgrade.index')
			->with('groups', $groups)
			->with('color', new Color);
	}
}