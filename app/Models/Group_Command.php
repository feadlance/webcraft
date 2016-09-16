<?php

namespace Webcraft\Models;

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
}