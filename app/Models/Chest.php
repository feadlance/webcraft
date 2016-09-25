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
		'opened' => 'boolean',
		'number' => 'integer'
	];

	public $timestamps = false;

	public function getInventoryAttribute($value)
	{
		return json_decode($value, true);
	}

	public function scopeAvailable($query)
	{
		foreach ( $query->get() as $chest ) {
			if ( count($chest->inventory) >= config('minecraft.sqlchest.slot') ) {
				continue;
			}

			return $chest;
		}
	}

	public function scopeTotalInventoryItem($query)
	{
		$total = [];
		
		foreach ( $query->get() as $chest ) {
			$total[] = count($chest->inventory);
		}

		return array_sum($total);
	}

	public function user()
	{
		return $this->belongsTo('Webcraft\Models\User', 'username', 'username')->first();
	}

	public function material($i)
	{
		return MinecraftMaterial::find($this->inventory[$i][0], $this->inventory[$i][1]);
	}

	public function name($i)
	{
		return $this->material($i) ? $this->material($i)->name : null;
	}

	public function displayName($i)
	{
		return $this->inventory[$i][2];
	}

	public function nameOrDisplayName($i)
	{
		return $this->displayName($i) ?: $this->name($i); 
	}

	public function icon($i)
	{
		return 'global/images/minecraft/items/' . $this->inventory[$i][0] . '-' . $this->inventory[$i][1] . '.png';
	}

	public function tooltipTitle($i)
	{
		$return = $this->nameOrDisplayName($i);

		if ( count($this->inventory[$i][6]) ) {
			$return .= '<br><br>';

			foreach ( $this->inventory[$i][6] as $enchant ) {
				$return .= '' . trans('minecraft.materials.enchants.' . $enchant[0]) . ' ' . RomanNumerals::decimalToRoman($enchant[1]) . '<br>';
			}
		}

		return $return;
	}

	public function addItem($type, $meta = 0, $name = null, $piece = 1, $durability = 0, $max_durability = 0, $skills = null)
	{
		$slot = count($this->inventory);

		if ( $slot >= config('minecraft.sqlchest.slot') ) {
			return false;
		}

		for ($i=0; $i < config('minecraft.sqlchest.slot'); $i++) { 
			if ( isset($this->inventory[$i]) !== true ) {
				$available_slot = $i;
				break;
			}
		}

		$inventory = $this->inventory;

		$inventory[$available_slot] = [
			$type,
			$meta,
			$name,
			$piece,
			$durability,
			$max_durability,
			$skills
		];

		$this->inventory = json_encode((object) $inventory);
		$this->save();

		return true;
	}
}