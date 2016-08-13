<?php

namespace Webcraft\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $table = 'comments';

	protected $fillable = [
		'body',
		'parent_id'
	];

	public function user()
	{
		return $this->belongsTo('Webcraft\Models\User', 'user_id')->first();
	}

	public function likes()
	{
		return $this->morphMany('Webcraft\Models\Like', 'likeable');
	}
}