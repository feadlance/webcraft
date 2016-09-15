<?php

namespace Webcraft\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $fillable = [
    	'title',
    	'group',
    	'money'
    ];

    public function getMoney()
    {
    	return number_format($this->money, 2);
    }

    public function getFeatures()
    {
        return $this->hasMany('Webcraft\Models\Group_Feature');
    }

    public function getCommands()
    {
        return $this->hasMany('Webcraft\Models\Group_Command');
    }
}