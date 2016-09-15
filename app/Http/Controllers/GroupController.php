<?php

namespace Webcraft\Http\Controllers;

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

		$commands = [];

		foreach ( $group->getCommands()->get() as $command ) {
			$commands[] = $command->command;
		}

		return Response::json([
			'success' => true,
			'group' => [
				'title' => $group->title,
				'money' => $group->money,
				'commands' => $group->getCommands()->get(),
				'features' => $group->getFeatures()->get()
			]
		]);
	}

	public function postNew(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'title' => 'required|max:100',
			'money' => 'required|regex:/^\d*(\.\d{2})?$/',
			'commands' => 'max:700'
		]);

		$validator->setAttributeNames([
			'title' => 'Grup başlığı',
			'money' => 'Fiyat',
			'commands' => 'Komutlar'
		]);

		if ( $validator->fails() ) {
			return Response::json(['errors' => $validator->errors()]);
		}

		$group = Group::find($request->input('id'));

		if ( $group === null ) {
			$new = true;
			$group = Group::create($request->only(['title', 'money']));
		} else {
			$group->update($request->only(['title', 'money']));
		}

		$group->getCommands()->delete();

		$commands = explode("\n", $request->input('commands'));

		foreach ( $commands as $command ) {
			if ( !empty(trim($command)) && !$group->getCommands()->where('command', $command)->count() ) {
				$group->getCommands()->create(['command' => trim($command)]);
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