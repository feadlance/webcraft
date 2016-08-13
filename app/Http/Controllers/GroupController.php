<?php

namespace Webcraft\Http\Controllers;

use Webcraft\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
	public function postNewAjax(Request $request, \Websend $ws)
	{
		$validator = \Validator::make($request->all(), [
			'title' => 'required|min:3|max:100|regex:/^[\pL\s\-]+$/u',
			'description' => 'min:3|max:300',
			'group' => 'required|max:100|alpha_dash',
			'balance' => 'required|regex:/^\d*(\.\d{2})?$/',
			'game' => 'boolean'
		]);

		if ( $validator->fails() ) {
			return \Response::json(['errors' => $validator->errors()]);
		}

		$group = Group::create([
			'title' => $request->input('title'),
			'description' => $request->input('description'),
			'group' => $request->input('group'),
			'balance' => $request->input('balance')
		]);

		if ( $request->input('game') ) {
			$ws->console('pex group ' . $request->input('group') . ' create');
		}

		return \Response::json([
			'title' => $group->title,
			'description' => $group->description,
			'group' => $group->group,
			'balance' => $group->getBalance()
		]);
	}
}