<?php

namespace Webcraft\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'title',
        'description',
        'code',
        'balance'
    ];

    public function getBalance()
    {
    	return number_format($this->balance, 2);
    }

    public function getCode($split = ':')
    {
        $code = explode(':', $this->code);
        $return = $code[0] . $split;

        return isset($code[1]) === true ? empty($code[1]) !== true ? $return . $code[1] : $return . 0 : $return . 0;
    }
}