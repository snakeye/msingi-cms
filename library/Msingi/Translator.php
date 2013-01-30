<?php

/**
 * @package Msingi
 */
interface Msingi_Translator
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