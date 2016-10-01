<?php

namespace Webcraft\Models;

use Illuminate\Database\Eloquent\Model;

class iConomy extends Model
{
	protected $table = 'iconomy';

	protected $fillable = [
		'username',
		'balance',
		'status'
	];

	public $timestamps = false;

	public function format()
	{
		return number_format($this->balance, 2);
	}

	public function give($balance, $give = true)
	{
		$balance = $give === true ? $this->balance + $balance : $this->balance - $balance;

		$this->balance = $balance;
		$this->save();

		return true;
	}

	public function take($balance)
	{
		return $this->give($balance, false);
	}
}