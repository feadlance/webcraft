<?php

namespace Webcraft\Http\Controllers;

use Webcraft\Models\Comment;
use Webcraft\Models\Status;

use Illuminate\Http\Request;

class CommentController extends Controller
{
	public function putLike($id)
	{
		$comment = Comment::find($id);

		if ( $comment === null ) {
			return \Response::json(['error' => 'Yorum bulunamadı.']);
		}

		$status = Status::find($comment->status_id);

		if ( $status === null ) {
			return \Response::json(['error' => 'Post bulunamadı.']);
		}

		if ( \Auth::id() !== $status->user()->id && !\Auth::user()->isFriendsWith($status->user()) ) {
			return \Response::json(['error' => 'Siz arkadaş değilsiniz.']);
		}

		if ( \Auth::user()->hasLikedComment($comment) ) {
			$comment->likes()->where('user_id', \Auth::id())->delete();
			$json = ['success' => true, 'liked' => false, 'like_count' => $comment->likes()->count()];
		} else {
			$like = $comment->likes()->create([]);
			\Auth::user()->likes()->save($like);
			$json = ['success' => true, 'liked' => true, 'like_count' => $comment->likes()->count()];
		}

		return \Response::json($json);
	}
}