<?php
declare(strict_types=1);
namespace Slavlee\SlavleeCookieControl\Utility;

/***
 *
 * This file is part of the "SlavleeCookieControl" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Kevin Chileong Lee &lt;support@slavlee.de&gt;, Slavlee
 *
 ***/

class RegexUtility
{
	/**
	 * Escape all regex control characters and returns the processed string
	 * @param string $string
	 * @return string
	 */
	static public function escapeRegexCharacters($string)
	{
		$string = str_replace('.', '\.', $string);
		$string = str_replace('/', '\/', $string);
		
		return $string;
	}
}