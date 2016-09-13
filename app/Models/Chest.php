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
		'inventory' => 'array',
		'opened' => 'boolean'
	];

	public $timestamps = false;

	public function user()
	{
		return $this->belongsTo('Webcraft\Models\User', 'username', 'username')->first();
	}

	public function material($i)
	{
		return MinecraftMaterial::find($this->inventory[$i][1], $this->inventory[$i][2]);
	}

	public function name($i)
	{
		return $this->material($i) ? $this->material($i)->name : null;
	}

	public function displayName($i)
	{
		return $this->inventory[$i][3];
	}

	public function nameOrDisplayName($i)
	{
		return $this->displayName($i) ?: $this->name($i); 
	}

	public function icon($i)
	{
		return 'global/images/minecraft/items/' . $this->inventory[$i][1] . '-' . $this->inventory[$i][2] . '.png';
	}
}