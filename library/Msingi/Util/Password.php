<?php

/**
 * Password generator
 *
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Util_Password
{

	/**
	 * Generate password of given length
	 *
	 * @param integer $length password length
	 * @return string
	 */
	static function generate($length = 8)
	{
		// start with a blank password
		$password = "";

		// define possible characters
		$possible = "0123456789bcdfghjkmnpqrstvwxyz";

		// set up a counter
		$i = 0;

		// add random characters to $password until $length is reached
		while ($i < $length)
		{
			// pick a random character from the possible ones
			$char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);

			// uppercase characters
			if (mt_rand(0, 1) == 1)
				$char = strtoupper($char);

			// we don't want this character if it's already in the password
			if (!strstr($password, $char))
			{
				$password .= $char;
				$i++;
			}
		}

		// done!
		return $password;
	}

}