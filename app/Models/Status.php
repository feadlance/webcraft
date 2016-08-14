<?php

namespace Webcraft\Models;

use Webcraft\Helpers\Functions\SocialFunction;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
	protected $table = 'statuses';

	protected $fillable = [
		'body',
		'wall_id'
	];

	public function user()
	{
		return $this->belongsTo('Webcraft\Models\User', 'user_id')->first();
	}

	public function comments($parent_id = 0)
	{
		$comments = $this->hasMany('Webcraft\Models\Comment', 'status_id');
		
		return $parent_id === 'all' ? $comments : $comments->where('parent_id', $parent_id);
	}

	public function likes()
	{
		return $this->morphMany('Webcraft\Models\Like', 'likeable');
	}

	public function postFormat()
	{
		/* Resource */
		$body = nl2br(htmlentities($this->body, ENT_QUOTES));

		/* Replaces */
		$body = SocialFunction::youtubeToEmbed($body);
		$body = SocialFunction::vimeoToEmbed($body);

		/* Return */
        return $body;
	}
}