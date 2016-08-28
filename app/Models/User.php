<?php

namespace Webcraft\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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
		return 'https://minotar.net/avatar/' . $this->username . '/' . $size;
	}

	public function getSkin($size = 100)
	{
		return 'https://minotar.net/body/' . $this->username . '/' . $size;
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
	    return Status::where('wall_id', $this->id);
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

	public function getBalance($format = false)
	{
		$balance = $this->belongsTo('Webcraft\Models\Iconomy', 'username', 'username')->first();
		
		if ( $balance === null ) {
			$balance = 0;
		} else {
			$balance = $balance->balance;
		}

		return $format === true ? number_format($balance, 2) : $balance;
	}

	public function giveBalance($ws, $balance)
	{
		return $ws->console('money give ' . $this->username . ' ' . $balance);
	}

	public function takeBalance($ws, $balance)
	{
		return $ws->console('money take ' . $this->username . ' ' . $balance);
	}

	public function giveItem($ws, $item, $piece)
	{
		return $ws->console('give ' . $this->username . ' ' . $item . ' ' . $piece);
	}

	public function setGroup($ws, $group)
	{
		return $ws->console('pex user ' . $this->username . ' group set ' . $group);
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