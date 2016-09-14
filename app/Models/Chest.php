<?php

namespace Webcraft\Models;

use MinecraftMaterial;
use Illuminate\Database\Eloquent\Model;
use Webcraft\Helpers\Functions\RomanNumerals;

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
		'opened' => 'boolean'
	];

	public $timestamps = false;

	public function getInventoryAttribute($value)
	{
		return json_decode($value, true);
	}

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

	public function tooltipTitle($i)
	{
		$return = $this->nameOrDisplayName($i);

		if ( count($this->inventory[$i][7]) ) {
			$return .= '<br><br>';

			foreach ( $this->inventory[$i][7] as $enchant ) {
				$return .= '' . trans('minecraft.materials.enchants.' . $enchant[0]) . ' ' . RomanNumerals::decimalToRoman($enchant[1]) . '<br>';
			}
		}

		return $return;
	}
}