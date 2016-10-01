<?php

namespace Webcraft\Helpers\Minecraft\Materials;

class Material
{
	public static function get()
	{
		return json_decode(file_get_contents(app_path('Helpers/Minecraft/Materials/materials.json')));
		
		return json_decode($materials_json);
	}

	public static function find($material, $meta = 0, $split = ':')
	{
		$value = null;

		$material = (int) $material;
		$meta = (int) $meta;

		$material = array_where(self::get(), function ($value, $key) use ($material, $meta) {
			return $value->type === $material && $value->meta === $meta;
		});

		foreach ( $material as $key => $value ) {
			$value->code = $value->meta !== 0 ? $value->type . $split . $value->meta : $value->type;
		}

		return $value;
	}
}