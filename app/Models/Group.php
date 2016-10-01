<?php

namespace Webcraft\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $fillable = [
    	'title',
    	'money'
    ];

    protected $casts = [
        'money' => 'array'
    ];

    public function getMinimumPrice($format = false)
    {
        $min = [];

        foreach ( $this->money as $money ) {
            $min[] = $money['money'];
        }

        return $format !== true ? min($min) : number_format(min($min), 2);
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