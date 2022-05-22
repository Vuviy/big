<?php

namespace WezomCms\Core\Foundation;

class Icon
{
	public static function getAllIconAsName(string $file):array
	{
		$symbols = [];
		$content = file_get_contents(static::getSpriteFileName($file));
		if ($content) {
			preg_match_all('/<symbol\s((?!<).)*>/', $content, $_symbols);
			if ($_symbols) {
				foreach ($_symbols[0] as $_symbol) {
					preg_match_all('/id="(((?!").)*)"/', $_symbol, $_ids);
					if ($_ids) {
					    $symbols[] = $_ids[1][0];
					}
				}
			}
		}

		return $symbols;
	}

	public static function getForSelect(string $file = 'admin'): array
	{
		$data = [];

		foreach (self::getAllIconAsName($file) as $item) {
			$data[$item] = r2d2()->svgSymbol($item, [
				'class' => '_svg-spritemap__icon',
				'width' => 50,
				'height' => 50
			], asset(static::getSpriteFileName($file)));
		}

		return $data;
	}

	public static function renderForAdmin($icon, string $file = 'admin')
	{
		return r2d2()->svgSymbol($icon, [
			'class' => '_svg-spritemap__icon',
			'width' => 50,
			'height' => 50
		], asset(static::getSpriteFileName($file)));
	}

	protected static function getSpriteFileName(string $file = 'admin'): string
    {
        $config = config('cms.ui.ui.svg', []);

        return $config[$file . 'Sprite'] ?? current($config);
    }
}
