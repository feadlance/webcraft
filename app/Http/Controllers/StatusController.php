<?php

namespace Webcraft\Http\Controllers;

use Auth;
use Response;
use Validator;
use Webcraft\Models\User;
use Webcraft\Models\Comment;
use Webcraft\Models\Status;

use Illuminate\Http\Request;

class StatusController extends Controller
{
	public function postStatus(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'body' => 'required|max:1000'
		]);

		$validator->setAttributeNames([
			'body' => 'Bir yazı yazmanız'
		]);

		$player = $request->input('player');

		$wall = User::where('username', $player)->first();

		if ( $wall !== null ) {
			$wall_id = $wall->id;
			
			if ( !Auth::user()->isAdmin() && (Auth::id() !== $wall_id && !Auth::user()->isFriendsWith($wall)) ) {
				return Response::json(['error' => 'Bu duvarda paylaşım yapmak için sahibiyle arkadaş olmalısın.']);
			}
		}

		if ( $validator->fails() ) {
			return Response::json(['error' => $validator->errors()->first('body')]);
		}

		$status = Auth::user()->getMyStatuses()->create([
			'body' => $request->input('body'),
			'wall_id' => $wall_id
		]);

		return Response::json([
			'success' => true,
			'data' => [
				'id' => $status->id,
				'avatar' => $status->user()->getAvatar(40),
				'display_name' => $status->user()->getDisplayName(),
				'profile_link' => route('profile', ['player' => $status->user()->username]),
				'created_at' => $status->created_at->diffForHumans(),
				'body' => $status->postFormat()
			]
		]);
	}

	public function postDelete(Request $request)
	{
		$status = Status::find($request->input('id'));

		if ( $status === null ) {
			return Response::json(['error' => 'Post bulunamadı.']);
		}

		if ( Auth::user()->isAdmin() !== true && Auth::id() !== $status->user_id && Auth::id() !== $status->wall_id ) {
			return Response::json(['error' => 'Bu postu silemezsiniz.']);
		}

		$status->delete();
		$status->comments('all')->delete();

		return Response::json(['success' => true]);
	}

	public function postLike(Request $request)
	{
		$status = Status::find($request->input('id'));

		if ( $status === null ) {
			return Response::json(['error' => 'Post bulunamadı.']);
		}

		if ( Auth::id() !== $status->user()->id && !Auth::user()->isFriendsWith($status->user()) ) {
			return Response::json(['error' => 'Siz arkadaş değilsiniz.']);
		}

		if ( Auth::user()->hasLikedStatus($status) ) {
			$status->likes()->where('user_id', Auth::id())->delete();
			$json = ['success' => true, 'liked' => false, 'count' => $status->likes()->count()];
		} else {
			$like = $status->likes()->create([]);
			Auth::user()->likes()->save($like);
			$json = ['success' => true, 'liked' => true, 'count' => $status->likes()->count()];
		}

		return Response::json($json);
	}
}