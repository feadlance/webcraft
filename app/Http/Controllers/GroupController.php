<?php

namespace Webcraft\Http\Controllers;

use Auth;
use View;
use Response;
use Validator;
use TurkishGrammar;
use Webcraft\Models\Group;
use Webcraft\Models\Group_Command;
use Webcraft\Models\Group_Feature;
use Illuminate\Http\Request;

class GroupController extends Controller
{
	public function postInfo(Request $request)
	{
		$group = Group::find($request->input('id'));

		if ( $group === null ) {
			return Response::json(['error' => 'Grup bulunamadı.']);
		}

		$features = [];

		foreach ( $group->getFeatures()->get() as $feature ) {
			$features[] = $feature->bodyFormat();
		}

		return Response::json([
			'success' => true,
			'group' => [
				'title' => $group->title,
				'money' => $group->money,
				'min_money' => $group->getMinimumPrice(true),
				'commands' => $group->getCommands()->get(),
				'features' => $features
			]
		]);
	}

	public function postNew(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'title' => 'required|max:100',
			'money.0' => 'required|regex:/^\d*(\.\d{2})?$/',
			'money.*' => 'required_with:money_day.*|regex:/^\d*(\.\d{2})?$/',
			'money_day.0' => 'required|numeric|max:100',
			'money_day.*' => 'required_with:money.*|numeric|max:100',
			'commands' => 'max:700',
			'expiry_commands' => 'max:700'
		]);

		$validator->setAttributeNames([
			'title' => 'Grup başlığı',
			'money.*' => 'Fiyat',
			'money_day.*' => 'Süre',
			'commands' => 'Komutlar',
			'expiry_commands' => 'Komutlar'
		]);

		if ( $validator->fails() ) {
			return Response::json(['errors' => $validator->errors()]);
		}

		$group = Group::find($request->input('id'));

		$money_array = [];

		for ($i=0; $i < count($request->input('money')); $i++) {
			if ( ($money_day = $request->input('money_day.' . $i)) && ($money = $request->input('money.' . $i)) ) {
				$money_array[] = [
					'day' => $money_day,
					'money' => $money
				];
			}
		}

		$group_create = [
			'title' => $request->input('title'),
			'money' => $money_array
		];

		if ( $group === null ) {
			$new = true;
			$group = Group::create($group_create);
		} else {
			$group->update($group_create);
		}

		$group->getCommands()->delete();

		$commands = [];
		$first_commands = explode("\n", $request->input('commands'));
		$last_commands = explode("\n", $request->input('expiry_commands'));

		foreach ( $first_commands as $command ) {
			$commands[] = [
				'type' => 'first',
				'command' => $command
			];
		}

		foreach ( $last_commands as $command ) {
			$commands[] = [
				'type' => 'last',
				'command' => $command
			];
		}

		foreach ( $commands as $command ) {
			if ( !empty(trim($command['command'])) && !$group->getCommands()->where('command', $command['command'])->where('type', $command['type'])->count() ) {
				$group->getCommands()->create($command);
			}
		}

		return Response::json([
			'success' => true,
			'data' => [
				'new' => isset($new) ? true : false,
				'layout' => View::make(app('template') . '.partials.group.group', ['group' => $group])->render()
			]
		]);
	}

	public function getDelete($id)
	{
		$group = Group::find($id);

		if ( $group === null ) {
			return Response::json(['error' => 'Grup bulunamadı.']);
		}

		$group->delete();
		$group->getCommands()->delete();
		$group->getFeatures()->delete();

		return Response::json(['success' => true]);
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

		return Response::json([
			'success' => true,
			'data' =>[
				'layout' => View::make(app('template') . '.partials.group.feature', ['feature' => $feature])->render()
			]
		]);
	}

	public function getDeleteFeature($id)
	{
		$feature = Group_Feature::find($id);

		if ( $feature === null ) {
			return Response::json(['error' => 'Özellik bulunamadı.']);
		}		

		$feature->delete();

		return Response::json(['success' => true]);
	}

	public function postNewCommand(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'id' => 'required|numeric|exists:groups',
			'command' => 'required|max:100'
		]);

		if ( $validator->fails() ) {
			return Response::json(['validations' => $validator->errors()]);
		}

		$group = Group::find($request->input('id'));

		if ( $group === null ) {
			return Response::json(['error' => 'Bu özelliği eklemek istediğiniz grubu bulamadık.']);
		}

		if ( $group->getCommands()->where('command', $request->input('command'))->count() ) {
			return Response::json(['error' => 'Bu gruba bu komutu zaten eklemişsiniz.']);
		}

		$command = $group->getCommands()->create([
			'command' => $request->input('command')
		]);

		return Response::json([
			'success' => true,
			'data' =>[
				'command' => $command->command,
				'delete_link' => route('group.delete.command', ['id' => $command->id])
			]
		]);
	}

	public function getDeleteCommand($id)
	{
		$command = Group_Command::find($id);

		if ( $command !== null ) {
			$command->delete();
		}		

		return redirect()->back();
	}
}