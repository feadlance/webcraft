<?php

namespace Webcraft\Helpers\Minecraft;

use Config;
use MinecraftQuery;

class Server extends Query
{
	public function __construct()
	{
		/*
		$query = new MinecraftQuery(Config::get('minecraft'));

		if ( $query->connect() ) {
			$this->info = $query->get_info();
			$query->disconnect();
		}

		return false;
		*/
	}

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
		return $this->port() !== '25565' ? $this->host() . ':' . $this->port() : $this->host();
	}

	public function motd()
	{
		//return $this->info['description'];
	}

	public function plugins()
	{
		//return $this->info['plugins'];
	}

	public function version()
	{
		//return $this->info['version'];
	}

	public static function favicon()
	{
		return 'assets/images/default-logo.svg';
	}

	public function players()
	{
		//return $this->info['players'];
	}

	public function slot()
	{
		//return $this->info['maxplayers'];
	}

	public function playerCount()
	{
		//return $this->info['numplayers'];
	}
}