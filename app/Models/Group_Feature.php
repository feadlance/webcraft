<?php

namespace Webcraft\Models;

use Webcraft\Helpers\Minecraft\Color;
use Illuminate\Database\Eloquent\Model;

class Group_Feature extends Model
{
    protected $table = 'group_features';

    protected $fillable = [
    	'body'
    ];

    public function group()
    {
    	return $this->belongsTo('Webcraft\Models\Group')->first();
    }

    public function bodyFormat()
    {
    	return Color::html($this->body);
    }
}