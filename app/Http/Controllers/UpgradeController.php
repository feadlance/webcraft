<?php

namespace Webcraft\Http\Controllers;

use Auth;
use Websend;
use Response;
use Carbon\Carbon;
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

	public function postBuy(Request $request, Websend $ws)
	{
		$group = Group::find($request->input('id'));

		if ( $group === null ) {
			return Response::json(['error' => 'Grup bulunamadı.']);
		}

		$selected_money_array = explode('_', $request->input('money'));

		$selected_day = (int) $selected_money_array[0];
		$selected_money = isset($selected_money_array[1]) ? (float) $selected_money_array[1] : null;
		$selected_index = isset($selected_money_array[2]) ? (int) $selected_money_array[2] : null;

		if ( isset($group->money[$selected_index]) !== true ) {
			return Response::json(['error' => 'Bu fiyat seçeneği geçerli değil.']);
		}

		if ( (float) $group->money[$selected_index]['money'] !== $selected_money || (int) $group->money[$selected_index]['day'] !== $selected_day ) {
			return Response::json(['error' => 'Seçtiğiniz fiyat silinmiş ya da değiştirilmiş, lütfen sayfayı yenileyip tekrar deneyin.']);
		}

		if ( $group->money[$selected_index]['money'] > Auth::user()->money ) {
			return Response::json(['error' => 'Bu grubu almak için yeterli paranız yok.']);
		}

		if ( !$ws->connect() ) {
			return Response::json(['error' => 'Sunucu ile bağlantı kurulamadığı için grup komutlarını gönderemedik, lütfen admine bildir.']);
		}

		foreach ( $group->getCommands()->where('type', 'first')->get() as $command ) {
			$ws->doCommandAsConsole('csync add ' . $command->replaceCommand(Auth::user(), ' '));
		}

		foreach ( $group->getCommands()->where('type', 'last')->get() as $command ) {
			$ws->doCommandAsConsole('csync add time ' . Carbon::now()->addDays(1) . ' ' . $command->replaceCommand(Auth::user(), ' '));
		}
		
		$ws->disconnect();

		Auth::user()->takeMoney($group->money[$selected_index]['money']);

		return Response::json(['success' => true]);
	}
}