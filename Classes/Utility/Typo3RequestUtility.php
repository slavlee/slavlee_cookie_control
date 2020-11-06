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

class Typo3RequestUtility
{
    /**
     * Return the current domain stack, that means if the current domain is a subdomain,
     * then it returns
     * 1. current domain
     * 2. current subdomain
     * 
     * If current domain is a normal domain, then it return
     * 1. current domain
     * @return array
     */
    public static function getCurrentDomainStack()
    {
        $stack = [];
        $host = self::getCurrentHost();
        
        // check if we have a domain or subdomain
        $hostSplit = GeneralUtility::trimExplode('.', $host);
        $hostSplitCount = count($hostSplit);
        
        // if host split > 1, then we have a subdomain
        if ($hostSplitCount > 2)
        {
            // get domain
            $stack[] = $hostSplit[$hostSplitCount-2] . '.' . $hostSplit[$hostSplitCount-1];
            $stack[] = $host;
        }else
        {
            $stack[] = $host;
        }
        
        return $stack;
    }
    
    /**
     * Return the current host without protocol
     * @return string
     */
    public static function getCurrentHost()
    {
        $host = '';
        
        if ($GLOBALS['TYPO3_REQUEST'])
        {
            $host = $GLOBALS['TYPO3_REQUEST']->getAttribute('site')->getBase()->getHost();
        }else
        {
            $host = $_SERVER['HTTP_HOST'];
        }
        
        return $host;
    }
}