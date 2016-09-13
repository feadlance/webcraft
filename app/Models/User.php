<?php

namespace Webcraft\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;
	
	protected $table = 'users';

	protected $fillable = [
	    'username',
	    'password',
	    'money',
	    'ip',
	    'lastlogin',
	    'x',
	    'y',
	    'z',
	    'world',
	    'email',
	    'about',
	    'birthday',
	    'realname',
	    'mobile',
	    'city',
	    'sex',
	    'isLogged',
	    'isVerified',
	    'isAdmin',
	    'remember_token',
	    'action_token'
	];

	protected $hidden = [
	    'password',
	    'remember_token',
	];

	/*
	* Get Attributes
	*/

	public function getLastloginAttribute($value)
	{
		return mb_substr($value, 0, 10, 'UTF-8');
	}

	/*
	* Personal Informations
	*/

	public function getDisplayName($filter = null)
	{
		$displayName = $this->realname ?: $this->username;

		$filter = explode('|', $filter);

		if ( in_array('firstname', $filter) ) {
			$displayName = strtok($displayName, ' ');
		}

		return $displayName;
	}

	public function getAvatar($size = 60)
	{
		return 'http://mcapi.ca/avatar/2d/' . $this->username . '/' . $size . '/true';
	}

	public function getSkin($size = 100)
	{
		return 'https://mcapi.ca/skin/2d/' . $this->username . '/' . $size . '/true';
	}

	public function getSex()
	{
	    return $this->sex === 1 ? 'Erkek' : ($this->sex !== 0 ? 'Kadın' : false);
	}

	/*
	* Money
	*/

	public function getMoney()
	{
	    return number_format($this->money, 2);
	}

	public function giveMoney($money)
	{
	    return $this->update([ 
	        'money' => $this->money + $money
	    ]);
	}

	public function takeMoney($money)
	{
	    return $this->update([
	        'money' => $this->money - $money
	    ]);
	}

	/*
	* Check Functions
	*/

	public function isVerified()
	{
	    return $this->isVerified === 1;
	}

	public function isAdmin()
	{
	    return $this->isAdmin === 1;
	}

	/*
	* Statuses
	*/

	public function getMyStatuses()
	{
	    return $this->hasMany('Webcraft\Models\Status', 'user_id');
	}

	public function getProfileStatuses()
	{
	    return Status::where(function($query) {
	    	return $query->where('wall_id', $this->id)->orWhere('wall_id', 0);
	    })->orWhere('user_id', $this->id);
	}

	public function getHomeStatuses()
	{
	    return Status::where(function ($query) {
	        return $query->where('user_id', $this->id)->orWhereIn('user_id', $this->friends()->pluck('id'));
	    })->where('wall_id', 0);
	}

	public function hasLikedStatus(Status $status)
	{
	    return (bool) $status->likes()->where('user_id', $this->id)->count();
	}

	public function hasLikedComment(Comment $comment)
	{
	    return (bool) $comment->likes()->where('user_id', $this->id)->count();
	}

	public function likes()
	{
	    return $this->hasMany('Webcraft\Models\Like', 'user_id');
	}

	public function comments()
	{
	    return $this->hasMany('Webcraft\Models\Comment', 'user_id');
	}

	/*
	* Game
	*/

	public function game()
	{
		return $this->belongsTo('Webcraft\Models\Stats3\Player', 'username', 'name')->first();
	}

	public function chests()
	{
		return $this->hasMany('Webcraft\Models\Chest', 'username', 'username');
	}

	public function market()
	{
		return $this->hasMany('Webcraft\Models\Community_Market', 'user_id');
	}

	/*
	* Friends
	*/

	public function friendsOfMine()
	{
		return $this->belongsToMany('Webcraft\Models\User', 'friends', 'user_id', 'friend_id');
	}

	public function friendOf()
	{
		return $this->belongsToMany('Webcraft\Models\User', 'friends', 'friend_id', 'user_id');
	}

	public function friends()
	{
		return $this->friendsOfMine()->wherePivot('accepted', true)->get()
			->merge($this->friendOf()->wherePivot('accepted', true)->get());
	}

	public function friendRequests()
	{
		return $this->friendsOfMine()->wherePivot('accepted', false)->get();
	}

	public function friendRequestsPending()
	{
		return $this->friendOf()->wherePivot('accepted', false)->get();
	}

	public function hasFriendRequestPending(User $user)
	{
		return (bool) $this->friendRequestsPending()->where('id', $user->id)->count();
	}

	public function hasFriendRequestReceived(User $user)
	{
		return (bool) $this->friendRequests()->where('id', $user->id)->count();
	}

	public function addFriend(User $user)
	{
		$this->friendOf()->attach($user->id);
	}

	public function deleteFriend(User $user)
	{
		$this->friendOf()->detach($user->id);
		$this->friendsOfMine()->detach($user->id);
	}

	public function acceptFriendRequest(User $user)
	{
		$this->friendRequests()->where('id', $user->id)->first()->pivot->update([
			'accepted' => true,
			'friendstime' => \Carbon\Carbon::now()
		]);
	}

	public function isFriendsWith(User $user)
	{
		return (bool) $this->friends()->where('id', $user->id)->count();
	}
}