<?php

/**
 * @package Msingi
 */
class Msingi_Util_Template
{

	/**
	 *
	 * @param type $text
	 * @param type $replacements
	 * @return type
	 */
	public static function replaceTokens($text, $replacements)
	{
		if (preg_match_all('/%([A-Z0-9\-_]+)%/i', $text, $matches))
		{
			foreach ($matches[0] as $token)
			{
				$keyword = strtolower(trim($token, '%'));

				$replacement = isset($replacements[$keyword]) ? $replacements[$keyword] : '';

				$text = str_replace($token, $replacement, $text);
			}
		}

		return $text;
	}

}