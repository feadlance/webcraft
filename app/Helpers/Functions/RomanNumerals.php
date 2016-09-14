<?php

namespace Webcraft\Helpers\Functions;

class RomanNumerals
{
	public static function decimalToRoman($decimal)
	{
		if ( in_array($decimal, self::decimals()) ) {
			return self::roman()[$decimal - 1];
		}
	}

	private static function decimals()
	{
		for ($i=1; $i < 21; $i++) { 
			$numbers[] = $i;
		}

		return $numbers;
	}

	private static function roman()
	{
		return [
			'I',
			'II',
			'III',
			'IV',
			'V',
			'VI',
			'VII',
			'VIII',
			'IX',
			'X',
			'XI',
			'XII',
			'XIII',
			'XIV',
			'XV',
			'XVI',
			'XVII',
			'XVIII',
			'XIX',
			'XX'
		];
	}
}