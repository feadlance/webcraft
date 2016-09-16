<?php

namespace Webcraft\Http\Controllers;

use Response;
use Webcraft\Models\Group;
use Illuminate\Http\Request;

class UpgradeController extends Controller
{
	public function getIndex()
	{
		$groups = Group::orderBy('money', 'desc')->get();

		return view(app('template') . '.upgrade.index')
			->with('groups', $groups);
	}

	public function postBuy(Request $request)
	{
		$group = Group::find($request->input('id'));

		if ( $group === null ) {
			return Response::json(['error' => 'Grup bulunamadı.']);
		}

		if ( $group->money > Auth::user()->money ) {
			return Response::json(['error' => 'Bu grubu almak için yeterli paranız yok.']);
		}
	}
}