<?php

namespace Webcraft\Helpers\Functions;

class SocialFunction
{
	public static function youtubeToEmbed($url)
	{
		$url = preg_replace(
			'~https?://(?:[0-9A-Z-]+\.)?(?:youtu\.be/|youtube(?:-nocookie)?\.com\S*?[^\w\s-])([\w-]{11})(?=[^\w-]|$)[?=&+%\w.-]*~ix',
			'<div class="video-embed"><iframe src="https://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe></div>',
			$url
		);

		return $url;
	}

	public static function vimeoToEmbed($url)
	{
		$url = preg_replace(
			'/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',
			'<div class="video-embed"><iframe src="https://player.vimeo.com/video/$5" frameborder="0" allowfullscreen></iframe></div>',
			$url
		);

		return $url;
	}
}

