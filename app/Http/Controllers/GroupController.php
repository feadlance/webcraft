<?php

namespace Webcraft\Http\Controllers;

use Response;
use Validator;
use Webcraft\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
	public function postNew(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'title' => 'required|max:100',
			'group' => 'required|max:100|alpha_dash',
			'money' => 'required|regex:/^\d*(\.\d{2})?$/'
		]);

		if ( $validator->fails() ) {
			return Response::json(['errors' => $validator->errors()]);
		}

		$group = Group::create([
			'title' => $request->input('title'),
			'group' => $request->input('group'),
			'money' => $request->input('money')
		]);

		return Response::json(['success' => true]);
	}

	public function getDelete($id)
	{
		$group = Group::find($id);

		if ( $group === null ) {
			return redirect()->back();
		}

		$group->delete();
		$group->getFeatures()->delete();

		return redirect()->back()->with('flash_success', 'Grup başarıyla silindi.');
	}

	public function postNewFeature(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'id' => 'required|numeric|exists:groups',
			'body' => 'required|max:100|unique:group_features'
		]);

		if ( $validator->fails() ) {
			return Response::json(['validations' => $validator->errors()]);
		}

		$group = Group::find($request->input('id'));

		if ( $group === null ) {
			return Response::json(['error' => 'Bu özelliği eklemek istediğiniz grubu bulamadık.']);
		}

		$feature = $group->getFeatures()->create([
			'body' => $request->input('body')
		]);

		return Response::json(['success' => true, 'body' => $feature->bodyFormat()]);
	}
}