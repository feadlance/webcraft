<?php

namespace Webcraft\Models\Stats3;

use Illuminate\Database\Eloquent\Model;

class Kill extends Model
{
	protected $table = 'stats3_kill';

	public static function getEntityGroups()
	{
		return [
			'ANIMALS' => [
				'BAT',
				'CHICKEN',
				'COW',
				'MOOSHROOM',
				'PIG',
				'RABBIT',
				'SHEEP',
				'SKELETON_HORSE',
				'SQUID',
				'DONKEY',
				'HORSE',
				'MULE',
				'OCELOT',
				'WOLF'
			],
			'MONSTERS' => [
				'CAVE_SPIDER',
				'ENDERMAN',
				'POLAR_BEAR',
				'SPIDER',
				'ZOMBIE_PIGMAN',
				'CREEPER',
				'ELDER_GUARDIAN',
				'ENDERMITE',
				'GHAST',
				'GUARDIAN',
				'HUSK',
				'MAGMA_CUBE',
				'SHULKER',
				'SILVERFISH',
				'SKELETON',
				'SKELETON_HORSEMAN',
				'SLIME',
				'SPIDER_JOCKEY',
				'STRAY',
				'WITCH',
				'WITHER_SKELETON',
				'ZOMBIE',
				'ZOMBIE_VILLAGER',
				'GIANT',
				'KILLER_BUNNY',
				'ZOMBIE_HORSE'
			]
		];
	}

	public function user()
	{
		return $this->belongsTo('Webcraft\Models\Stats3\Player', 'uuid', 'uuid')->first()->getUser();
	}
}