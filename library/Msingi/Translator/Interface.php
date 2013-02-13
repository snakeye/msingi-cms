<?php

/**
 * Interface for objects supporting authomated translation
 *
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
interface Msingi_Translator_Interface
{

	// get current locale
	public function locale();

	// get current language
	public function language();

	// translate string
	public function translate($string);

	// translate string
	public function _($string);

	// sprintf translating wrapper
	public function _s($string);
}