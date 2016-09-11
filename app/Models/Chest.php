<?php

namespace Webcraft\Models;

use MinecraftMaterial;
use Illuminate\Database\Eloquent\Model;

class Chest extends Model
{
	protected $table = 'chests';

	protected $fillable = [
		'username',
		'number',
		'inventory',
		'opened'
	];

	protected $casts = [
		'inventory' => 'array'
	];

	public $timestamps = false;

	public function user()
	{
		return $this->belongsTo('Webcraft\Models\User', 'username', 'username')->first();
	}

	public function name($i)
	{
		return MinecraftMaterial::find($this->inventory[$i][0])->name;
	}

	public function icon($i)
	{
		$material = MinecraftMaterial::find($this->inventory[$i][0]);

		return 'global/images/minecraft/items/' . $material->type . '-' . $material->meta . '.png';
	}
}