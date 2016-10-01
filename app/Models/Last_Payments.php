<?php

namespace Webcraft\Models;

use Illuminate\Database\Eloquent\Model;

class Last_Payments extends Model
{
    protected $table = 'last_payments';

    protected $fillable = [
    	'code',
    	'method'
    ];

    public function user()
    {
    	return $this->belongsTo('Webcraft\Models\User', 'user_id')->first();
    }
}