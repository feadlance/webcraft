<?php

namespace Webcraft\Http\Controllers;

use Webcraft\Models\User;
use Webcraft\Models\Comment;
use Webcraft\Models\Status;

use Illuminate\Http\Request;

class StatusController extends Controller
{
	public function postStatus(Request $request)
	{
		$validator = \Validator::make($request->all(), [
			'body' => 'required|max:1000'
		]);

		$player = $request->input('player');

		$wall = User::where('username', $player)->first();
		$wall_id = 0;

		if ( $wall !== null ) {
			$wall_id = $wall->id;
		}

		if ( \Auth::id() !== $wall_id && !\Auth::user()->isFriendsWith($wall) ) {
			return \Response::json(['error' => 'Bu profilde paylaşım yapmak istiyorsan onunla arkadaş olmalısın.']);
		}

		if ( $validator->fails() ) {
			return \Response::json(['error' => $validator->errors()->first('body')]);
		}

		$status = \Auth::user()->getMyStatuses()->create([
			'body' => $request->input('body'),
			'wall_id' => $wall_id
		]);

		return \Response::json([
			'success' => true,
			'username' => $status->user()->username,
			'display_name' => $status->user()->getDisplayName(),
			'created_at' => $status->created_at->diffForHumans()
		]);
	}

	public function putDelete($id)
	{
		$status = Status::find($id);

		if ( $status === null ) {
			return \Response::json(['error' => 'Post bulunamadı.']);
		}

		if ( \Auth::id() !== $status->user_id && \Auth::id() !== $status->wall_id ) {
			return \Response::json(['error' => 'Bu postu silemezsiniz.']);
		}

		$status->delete();
		$status->comments('all')->delete();

		return \Response::json(['success' => true]);
	}

	public function putLikeStatus($id)
	{
		$status = Status::find($id);

		if ( $status === null ) {
			return \Response::json(['error' => 'Post bulunamadı.']);
		}

		if ( \Auth::id() !== $status->user()->id && !\Auth::user()->isFriendsWith($status->user()) ) {
			return \Response::json(['error' => 'Siz arkadaş değilsiniz.']);
		}

		if ( \Auth::user()->hasLikedStatus($status) ) {
			$status->likes()->where('user_id', \Auth::id())->delete();
			$json = ['success' => true, 'liked' => false, 'like_count' => $status->likes()->count()];
		} else {
			$like = $status->likes()->create([]);
			\Auth::user()->likes()->save($like);
			$json = ['success' => true, 'liked' => true, 'like_count' => $status->likes()->count()];
		}

		return \Response::json($json);
	}

	public function putCommentStatus(Request $request, $id)
	{
		$reply = $request->input('reply');
		$parent_id = 0;

		if ( $reply === 'true' ) {
			$comment = Comment::find($id);

			if ( $comment === null ) {
				return \Response::json(['error' => 'Yorum bulunamadı.']);
			}

			$parent_id = $comment->id;
			$id = $comment->status_id;
		}

		$status = Status::find($id);

		if ( $status === null ) {
			return \Response::json(['error' => 'Post bulunamadı.']);
		}

		if ( \Auth::id() !== $status->user()->id && !\Auth::user()->isFriendsWith($status->user()) ) {
			return \Response::json(['error' => 'Siz arkadaş değilsiniz.']);
		}

		$validator = \Validator::make($request->all(), [
			'body' => 'required|max:500'
		]);

		if ( $validator->fails() ) {
			return \Response::json(['error' => $validator->errors()->first('body')]);
		}

		$comments = $status->comments()->create([
			'body' => $request->input('body'),
			'parent_id' => $parent_id
		]);

		\Auth::user()->comments()->save($comments);

		return \Response::json([
			'success' => true,
			'comment_count' => $status->comments($parent_id)->count(),
			'username' => \Auth::user()->username,
			'display_name' => \Auth::user()->getDisplayName()
		]);
	}
}