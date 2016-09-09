<?php

namespace Webcraft\Models;

use MinecraftMaterial;
use Illuminate\Database\Eloquent\Model;

class Community_Market extends Model
{
	protected $table = 'community_market';

	protected $fillable = [
		'username',
		'item',
		'price',
		'piece',
		'durability',
		'skills',
	];

	public function user()
	{
		return $this->belongsTo('Webcraft\Models\User', 'username', 'username')->first();
	}

	public function material()
	{
		$explode = explode(':', $this->item);

		$item = $explode[0];
		$meta = isset($explode[1]) ? $explode[1] : 0;

		return MinecraftMaterial::find($item, $meta);
	}

	public function icon()
	{
		return 'global/images/minecraft/items/' . str_replace(':', '-', $this->item) . '.png';
	}

	public function price($total = false, $format = true)
	{
		$price = $total === true ? $this->price * $this->piece : $this->price;

		return $format === true ? number_format($price, 2) : $price;
	}
}