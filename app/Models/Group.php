<?php

namespace Webcraft\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $fillable = [
    	'title',
    	'description',
    	'group',
    	'balance'
    ];

    public function getBalance()
    {
    	return number_format($this->balance, 2);
    }
}