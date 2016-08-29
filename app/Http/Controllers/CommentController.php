<?php

namespace Webcraft\Http\Controllers;

use Auth;
use Response;
use Validator;

use Webcraft\Models\Comment;
use Webcraft\Models\Status;
use Webcraft\Notifications\LikeComment;
use Webcraft\Notifications\ReplyComment;
use Webcraft\Notifications\CommentStatus;

use Illuminate\Http\Request;

class CommentController extends Controller
{
	public function postComment(Request $request)
	{
		$parent_id = 0;
		$id = $request->input('id');

		if ( $request->input('type') === 'comment' ) {
			$comment = Comment::find($id);

			if ( $comment === null ) {
				return Response::json(['error' => 'Yorum bulunamadı.']);
			}

			$parent_id = $comment->id;
			$id = $comment->status_id;
		}

		$status = Status::find($id);

		if ( $status === null ) {
			return Response::json(['error' => 'Post bulunamadı.']);
		}

		if ( Auth::id() !== $status->user()->id && !Auth::user()->isFriendsWith($status->user()) ) {
			return Response::json(['error' => 'Siz arkadaş değilsiniz.']);
		}

		$validator = Validator::make($request->all(), [
			'body' => 'required|max:500'
		]);

		if ( $validator->fails() ) {
			return Response::json(['error' => $validator->errors()->first('body')]);
		}

		$insertComment = $status->comments()->create([
			'body' => $request->input('body'),
			'parent_id' => $parent_id
		]);

		Auth::user()->comments()->save($insertComment);

		if ( $request->input('type') === 'comment' ) {
			if ( Auth::id() !== $comment->user()->id ) {
				$comment->user()->notify(new ReplyComment(Auth::user(), $comment));
			}
		} else {
			if ( Auth::id() !== $status->user()->id ) {
				$status->user()->notify(new CommentStatus(Auth::user(), $status, $insertComment));
			}
		}

		return Response::json([
			'success' => true,
			'data' => [
				'id' => $insertComment->id,
				'count' => $status->comments($parent_id)->count(),
				'avatar' => $request->input('type') === 'status' ? $insertComment->user()->getAvatar(40) : $insertComment->user()->getAvatar(35),
				'profile_link' => route('profile', ['player' => $insertComment->user()->username]),
				'display_name' => $insertComment->user()->getDisplayName(),
				'body' => $insertComment->body,
				'created_at' => $insertComment->created_at->diffForHumans()
			]
		]);
	}

	public function postLike(Request $request)
	{
		$comment = Comment::find($request->input('id'));

		if ( $comment === null ) {
			return Response::json(['error' => 'Yorum bulunamadı.']);
		}

		$status = Status::find($comment->status_id);

		if ( $status === null ) {
			return Response::json(['error' => 'Post bulunamadı.']);
		}

		if ( Auth::id() !== $status->user()->id && !Auth::user()->isFriendsWith($status->user()) ) {
			return Response::json(['error' => 'Siz arkadaş değilsiniz.']);
		}

		if ( Auth::user()->hasLikedComment($comment) ) {
			$comment->likes()->where('user_id', Auth::id())->delete();
			$json = ['success' => true, 'liked' => false, 'count' => $comment->likes()->count()];
		} else {
			$like = $comment->likes()->create([]);

			Auth::user()->likes()->save($like);

			if ( Auth::id() !== $comment->user()->id ) {
				$comment->user()->notify(new LikeComment(Auth::user(), $comment));
			}

			$json = ['success' => true, 'liked' => true, 'count' => $comment->likes()->count()];
		}

		return Response::json($json);
	}
}