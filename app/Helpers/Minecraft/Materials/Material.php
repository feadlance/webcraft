<?php

namespace Webcraft\Helpers\Minecraft\Materials;

use stdClass;

class Material
{
	public static function get($type = 'json')
	{
		$return = [];

		if ( $type === 'txt' ) {
			$materials_txt = file_get_contents(app_path('Helpers/Minecraft/Materials/materials.txt'));
			$materials_txt = explode("\n", $materials_txt);

			foreach ( $materials_txt as $key => $material_txt ) {
				$material_info = explode(',', rtrim($material_txt, "\r"));

				$return[$key]['name'] = $material_info[0];
				$return[$key]['item'] = $material_info[1];
				$return[$key]['meta'] = isset($material_info[2]) ? $material_info[2] : 0;
			}

			return $return;
		}

		$materials_json = file_get_contents(app_path('Helpers/Minecraft/Materials/materials.json'));
		return json_decode($materials_json);
	}

	public static function find($material, $meta = 0, $split = ':')
	{
		$material_format = strtolower($material);
		$meta = (int) $meta;

		$material = array_where(self::get(), function ($value, $key) use ($material_format, $meta) {
			if ( is_numeric($material_format) ) {
				$material_format = (int) $material_format;
			}

			return ($value->text_type === $material_format || $value->type === $material_format) && $value->meta === $meta;
		});

		foreach ( $material as $key => $value ) {
			$value->code = $value->meta !== 0 ? $value->type . $split . $value->meta : $value->type;
		}

		if ( isset($value) === true ) {
			return $value;
		}

		$material_format = str_replace(['_', ' '], null, $material_format);
			
		foreach (self::get('txt') as $key => $value) {
			if ( $value['name'] === $material_format ) {
				$stdClass = new stdClass;
				$stdClass->type = (int) $value['item'];
				$stdClass->meta = (int) $meta;
				$stdClass->name = self::find($value['item'], $meta)->name;
				$stdClass->text_type = $material_format;
				$stdClass->code = $meta != 0 ? $value['item'] . $split . $meta : (int) $value['item'];
				break;
			}
		}

		return isset($stdClass) ? $stdClass : null;
	}
}