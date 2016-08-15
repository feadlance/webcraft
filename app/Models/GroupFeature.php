<?php

namespace Webcraft\Models;

use Webcraft\Helpers\Minecraft\Color;
use Illuminate\Database\Eloquent\Model;

class GroupFeature extends Model
{
    protected $table = 'group_features';

    protected $fillable = [
    	'body'
    ];

    public function bodyFormat()
    {
    	return Color::html($this->body);
    }
}