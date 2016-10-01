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

    public function replaceCommand(User $user)
    {
        if ( mb_substr($this->command, 0, 1, 'UTF-8') === '/' ) {
            $command = mb_substr($this->command, 1, null, 'UTF-8');
        }

    	return str_replace(['@p', '@g'], [$user->username, str_slug($this->group()->title, ' ')], $command);
    }
}