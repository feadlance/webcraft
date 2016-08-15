<?php

namespace Webcraft\Helpers\Minecraft;

use Config;

class Server
{
	public static function name()
	{
		return Config::get('minecraft.server.name');
	}

	public static function host()
	{
		return Config::get('minecraft.server.host');
	}

	public static function port()
	{
		return Config::get('minecraft.server.port');
	}

	public static function fullHost()
	{
		return self::port() !== '25565' ? self::host() . ':' . self::port() : self::host();
	}

	public static function motd()
	{
		return 'test';
	}

	public static function version()
	{
		return 1.9;
	}

	public static function favicon()
	{
		return 'assets/images/default-logo.svg';
	}
}