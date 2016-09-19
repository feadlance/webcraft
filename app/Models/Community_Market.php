<?php

namespace Webcraft\Models;

use MinecraftMaterial;
use Illuminate\Database\Eloquent\Model;

class Community_Market extends Model
{
	protected $table = 'community_market';

	protected $fillable = [
		'name',
		'price',
		'piece',
		'type',
		'meta',
		'durability',
		'max_durability',
		'skills'
	];

	protected $casts = [
		'skills' => 'array'
	];

	public function user()
	{
		return $this->belongsTo('Webcraft\Models\User', 'user_id')->first();
	}

	public function material()
	{
		return MinecraftMaterial::find($this->type, $this->meta);
	}

	public function icon()
	{
		return 'global/images/minecraft/items/' . $this->type . '-' . $this->meta . '.png';
	}

	public function price($total = false, $format = true)
	{
		$price = $total === true ? $this->price * $this->piece : $this->price;

		return $format === true ? number_format($price, 2) : $price;
	}
}