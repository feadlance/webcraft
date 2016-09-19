<?php

namespace Webcraft\Models;

use Webcraft\Models\User;
use Illuminate\Database\Eloquent\Model;

class Group_Command extends Model
{
    protected $table = 'group_commands';

    protected $fillable = [
    	'type',
    	'command'
    ];

    public function group()
    {
    	return $this->belongsTo('Webcraft\Models\Group')->first();
    }

    public function replaceCommand(User $user, $slug = false)
    {
    	$title = $slug !== false ? str_slug($this->group()->title, $slug) : $this->group()->title;

    	return str_replace(['@p', '@g'], [$user->username, $title], $this->command);
    }
}