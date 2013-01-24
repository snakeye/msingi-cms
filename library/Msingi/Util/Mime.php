<?php

class Msingi_Util_Mime
{

	/**
	 *
	 * Enter description here ...
	 * @param unknown_type $file
	 */
	public static function content_type($file)
	{
		if (function_exists('finfo_open'))
		{
			$finfo = finfo_open(FILEINFO_MIME, '/usr/share/misc/magic');
			$mime = explode(';', finfo_file($finfo, $file));
			finfo_close($finfo);
			$mime = $mime[0];
		}
		else
		{
			$mime = mime_content_type($file);
		}

		// some extra processing by extension
		if ($mime == '' || $mime == 'application/octet-stream' || $mime == 'text/plain')
		{
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

			switch ($ext)
			{
				case 'jpeg':
				case 'jpg':
					$mime = 'image/jpeg';
					break;
				case 'png':
					$mime = 'image/png';
					break;
				case 'gif':
					$mime = 'image/gif';
					break;
				case 'mp3':
					$mime = 'audio/mpeg';
					break;
				case 'mp4':
					$mime = 'video/mp4';
					break;
				case 'wma':
					$mime = 'audio/x-ms-wma';
					break;
				case 'wmv':
					$mime = 'video/x-ms-wmv';
					break;
				case 'avi':
					$mime = 'video/avi';
					break;
				case 'mpg':
					$mime = 'video/quicktime';
					break;
				case 'flv':
					$mime = 'video/x-flv';
					break;
				case 'txt':
					$mime = 'text/plain';
					break;
			}
		}

		return $mime;
	}

}