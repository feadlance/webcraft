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

	public static function find($material, $meta = 0)
	{
		$material_format = strtolower($material);

		$material = array_where(self::get(), function ($value, $key) use ($material_format, $meta) {
			return $value->text_type === $material_format && $value->meta === $meta;
		});

		foreach ( $material as $key => $value ) {
			$value->code = $value->meta !== 0 ? $value->type . ':' . $value->meta : $value->type;
		}

		if ( isset($value) !== true ) {
			$material_format = str_replace(['_', ' '], null, $material_format);
			
			foreach (self::get('txt') as $key => $value) {
				if ( $value['name'] === $material_format ) {
					$stdClass = new stdClass;
					$stdClass->type = $value['item'];
					$stdClass->meta = $value['meta'];
					$stdClass->name = null;
					$stdClass->text_type = $material_format;
					$stdClass->code = $value['meta'] != 0 ? $value['item'] . ':' . $value['meta'] : $value['item'];
					$value = $stdClass;
					break;
				}
			}
		}

		$material_name_format = strtolower($value->name);
		$material_name_format = str_replace(['_', ' '], null, $material_name_format);

		$material_type_format = strtolower($value->text_type);
		$material_type_format = str_replace(['_', ' '], null, $material_type_format);

		foreach (self::get('txt') as $key => $value) {
			if ( $value['meta'] == $meta && ($value['name'] === $material_type_format || $value['name'] === $material_name_format) ) {
				return $value;
			}
		}
	}
}