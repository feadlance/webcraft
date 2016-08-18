<?php

namespace Webcraft\Http\Controllers;

use Response;
use Validator;
use Webcraft\Models\Group;
use Webcraft\Models\GroupFeature;
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

		$validator->setAttributeNames([
			'title' => 'Grup başlığı',
			'group' => 'Grubun oyundaki adı',
			'money' => 'Fiyat'
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

		return redirect()->back();
	}

	public function postNewFeature(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'id' => 'required|numeric|exists:groups',
			'body' => 'required|max:100'
		]);

		if ( $validator->fails() ) {
			return Response::json(['validations' => $validator->errors()]);
		}

		$group = Group::find($request->input('id'));

		if ( $group === null ) {
			return Response::json(['error' => 'Bu özelliği eklemek istediğiniz grubu bulamadık.']);
		}

		if ( $group->getFeatures()->where('body', $request->input('body'))->count() ) {
			return Response::json(['error' => 'Bu gruba bu özelliği zaten eklemişsiniz.']);
		}

		$feature = $group->getFeatures()->create([
			'body' => $request->input('body')
		]);

		return Response::json(['success' => true, 'body' => $feature->bodyFormat()]);
	}

	public function getDeleteFeature($id)
	{
		$feature = GroupFeature::find($id);

		if ( $feature === null ) {
			return redirect()->back();
		}

		$feature->delete();

		return redirect()->back();
	}
}