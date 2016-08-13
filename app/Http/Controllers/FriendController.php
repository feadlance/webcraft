<?php

namespace Webcraft\Http\Controllers;

use Webcraft\Models\User;
use Illuminate\Http\Request;

class FriendController extends Controller
{
	public function putAddFriend(Request $request, $player)
	{
		$user = User::where('username', $player)->first();

		if ( $user === null ) {
			return \Response::json(['error' => 'Arkadaş olarak eklemek istediğiniz oyuncuyu bulamadık.']);
		}

		if ( \Auth::id() === $user->id ) {
			return \Response::json(['error' => 'Kendinize istek gönderemezsiniz.']);
		}

		if ( \Auth::user()->hasFriendRequestPending($user) || $user->hasFriendRequestPending(\Auth::user()) ) {
			return \Response::json(['error' => 'Arkadaşlık isteği zaten gönderilmişti.']);
		}

		if ( \Auth::user()->isFriendsWith($user) ) {
			return \Response::json(['error' => 'Siz zaten arkadaşsınız.']);
		}

		\Auth::user()->addFriend($user);

		return \Response::json(['success' => true]);
	}

	public function putAcceptFriend(Request $request, $player)
	{
		$user = User::where('username', $player)->first();

		if ( $user === null ) {
			return \Response::json(['error' => 'Arkadaşlığını kabul etmek istediğiniz oyuncuyu bulamadık.']);
		}

		if ( !\Auth::user()->hasFriendRequestReceived($user) ) {
			return \Response::json(['error' => 'Bunu yapmayın.']);
		}

		\Auth::user()->acceptFriendRequest($user);

		return \Response::json(['success' => true]);
	}

	public function putDeleteFriend(Request $request, $player)
	{
		$user = User::where('username', $player)->first();

		if ( $user === null ) {
			return \Response::json(['error' => 'Arkadaşlıktan çıkartmak istediğiniz oyuncuyu bulamadık.']);
		}

		if ( !\Auth::user()->isFriendsWith($user) ) {
			return \Response::json(['error' => 'Siz zaten arkadaş değilsiniz.']);
		}

		\Auth::user()->deleteFriend($user);

		return \Response::json(['success' => true]);
	}
}