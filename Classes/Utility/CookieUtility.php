<?php
declare(strict_types=1);
namespace Slavlee\SlavleeCookieControl\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;

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

class CookieUtility
{
	/**
	 * Delete one cookie
	 * @param string $cookieToDelete
	 * @return void
	 */
	static function delete($cookieToDelete)
	{	    
		if ($_SERVER['HTTP_COOKIE'])
		{
			$cookies = GeneralUtility::trimExplode(';', $_SERVER['HTTP_COOKIE'], true);
			$currentDomainStack = Typo3RequestUtility::getCurrentDomainStack();
			$domain = $subdomain = '';
			
			if (count($currentDomainStack) == 1)
			{
                $domain = $currentDomainStack[0];
			}else
			{
			    $domain = $currentDomainStack[0];
			    $subdomain = $currentDomainStack[1];
			}
			
			foreach($cookies as $cookie) {
				$parts = GeneralUtility::trimExplode('=', $cookie, true);
				$name = trim($parts[0]);
			    	
				if ($cookieToDelete == $name)
				{
					setcookie($name, '', time()-1000, '/', $domain);
					setcookie($name, '', time()-1000, '/', '.' . $domain); // Some browser store domain with leading "."
					
					// Delete cookie for subdomain, if exists
					if (!empty($subdomain))
					{
					    setcookie($name, '', time()-1000, '/', $subdomain);
					}
				}
			}
		}
	}
	
	/**
	 * Deletes all cookies
	 * @param array $whitelist
	 * @return void
	 */
	static function deleteAll($whitelist = array())
	{
		if ($_SERVER['HTTP_COOKIE'])
		{
			$cookies = GeneralUtility::trimExplode(';', $_SERVER['HTTP_COOKIE'], true);
			foreach($cookies as $cookie) {
				$parts = explode('=', $cookie);
				$name = trim($parts[0]);
				
				if (!in_array($name, $whitelist))
				{				
					setcookie($name, '', time()-1000);
					setcookie($name, '', time()-1000, '/');
				}
			}
		}
	}
	
	/**
	 * Return cookie content
	 * @param string $name
	 * @return mixed
	 */
	static function getCookie($name)
	{
		return isset($_COOKIE[$name]) ? json_decode($_COOKIE[$name], true) : array();
	}
	
	/**
	 * Set a new cookie
	 * @param string $name
	 * @param mixed $data
	 * @param int $lifetime
	 * @return void
	 */
	static function setCookie($name, $data, $lifetime)
	{
		setcookie($name, json_encode($data), $lifetime);
	}
}