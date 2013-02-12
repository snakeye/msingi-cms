<?php
/**
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Util_Image
{

	/**
	 *
	 * @param type $file
	 * @return boolean
	 */
	public static function isImage($file)
	{
		if (!file_exists($file))
		{
			return false;
		}

		$size = getimagesize($file);
		if ($size === false)
		{
			return false;
		}

		return true;
	}

	/**
	 *
	 * @param $src
	 * @param $dest
	 * @param $width
	 * @param $height
	 * @param $cut
	 * @param $watermark
	 * @return unknown_type
	 */
	public static function resize($src, $dest, $width, $height, $cut = false, $watermark = '')
	{
		if (!Msingi_Util_Image::isImage($src))
			return false;

		$size = getimagesize($src);

		$format = strtolower(substr($size['mime'], strpos($size['mime'], '/') + 1));
		$icfunc = "imagecreatefrom" . $format;
		if (!function_exists($icfunc))
		{
			return false;
		}

		$isrc = $icfunc($src);

		if ($width == null && $height == null)
		{
			return false;
		}
		else if ($width != null && $height == null)
		{
			$x_ratio = $width / $size[0];
			$y_ratio = $x_ratio;
			$height = $height * $y_ratio;
		}
		else if ($width == null && $height != null)
		{
			$y_ratio = $height / $size[1];
			$x_ratio = $y_ratio;
			$width = $height * $x_ratio;
		}
		else if ($width != null && $height != null)
		{
			$x_ratio = $width / $size[0];
			$y_ratio = $height / $size[1];
		}

		if ($x_ratio < 1.0 || $y_ratio < 1.0)
		{
			if ($cut)
			{
				$ratiomax = max($x_ratio, $y_ratio);

				$src_left = floor(($size[0] - $width / $ratiomax) / 2);
				$src_top = floor(($size[1] - $height / $ratiomax) / 2);

				$new_width = $width;
				$new_height = $height;

				$idest = imagecreatetruecolor($width, $height);

				imagecopyresampled($idest, $isrc, 0, 0, $src_left, $src_top, $width, $height, $width / $ratiomax, $height / $ratiomax);
			}
			else
			{
				$ratio = min($x_ratio, $y_ratio);

				$new_width = floor($size[0] * $ratio);
				$new_height = floor($size[1] * $ratio);

				$idest = imagecreatetruecolor($new_width, $new_height);

				imagecopyresampled($idest, $isrc, 0, 0, 0, 0, $new_width, $new_height, $size[0], $size[1]);
			}
		}
		else
		{
			$new_width = $size[0];
			$new_height = $size[1];

			$idest = imagecreatetruecolor($new_width, $new_height);

			imagecopy($idest, $isrc, 0, 0, 0, 0, $new_width, $new_height);
		}

		// watermark
		if ($watermark != '')
		{
			$wm = imagecreatefrompng($watermark);
			imagealphablending($wm, false);
			imagesavealpha($wm, true);
			if ($wm)
			{
				$watermark_width = imagesx($wm);
				$watermark_height = imagesy($wm);
				$dest_x = ($new_width - $watermark_width) - 0;
				$dest_y = ($new_height - $watermark_height) - 0;
				imagecopy($idest, $wm, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height);
			}
		}

		//
		imageinterlace($idest, true);

		// create destination image
		imagejpeg($idest, $dest, 100);

		// set access rights
		chmod($dest, 0664);

		// clean up
		imagedestroy($isrc);
		imagedestroy($idest);

		return true;
	}

}