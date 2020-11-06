<?php
declare(strict_types = 1);
namespace Slavlee\SlavleeCookieControl\Hooks;

use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use Slavlee\SlavleeCookieControl\Utility\CookieUtility;
use Slavlee\SlavleeCookieControl\Utility\RegexUtility;

/*
 *  Copyright (c) 2017 Kevin Chileong Lee, http://www.slavlee.de
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in
 *  all copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  THE SOFTWARE.
 */

/**
 * Hook to remove cookies and disable external services from HTML
 * @author Kevin Chileong Lee
 * @copyright (c) 2018. Kevin Chileong Lee
 */
class CookieRemoverHook implements \TYPO3\CMS\Core\SingletonInterface
{
    /**
     * Regex for the html part that shall stay untouched
     * @var string
     */
    const REGEX_EXCLUDE_HTML_CODE = '/<!-- SCC_KEEP - START -->(.*)<!-- SCC_KEEP - END -->/s';
    
	/**
	 * $checkedCategories
	 * @var array
	 */
    protected $checkedCategories = [];
    
    /**
     * $checkedServices
     * @var array
     */
    protected $checkedServices = [];
	
	/**
	 * $settings
	 * @var array
	 */
	protected $settings = [];
	
	/**
	 * $cookiesToRemove
	 * @var array
	 */
	protected $cookiesToRemove = [];
	
	/**
	 * $urlsToDisable
	 * @var array
	 */
	protected $urlsToDisable = [];	
	
	/**
	 * $sessionData, cookie consent data from frontend user
	 * @var array
	 */
	protected $sessionData = [];
	
	/**
	 * $objectManager
	 * @var ObjectManager
	 */
	protected $objectManager;
	
	/**
	 * Create a CookieRemoverHook
	 * @return void
	 */
	public function __construct()
	{
	    $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);	    
		$this->settings = \Slavlee\SlavleeCookieControl\Utility\GeneralUtility::getTypoScriptSettings();
		
		if (count($this->settings) == 0)
		{
		    return;
		}
		
		$this->sessionData = \Slavlee\SlavleeCookieControl\Utility\GeneralUtility::getCategorySettingsFromSession();
		
		if (!empty($this->sessionData))
		{
		    $this->checkedCategories = $this->sessionData['checkedCategories'];		
		    $this->checkedServices = $this->sessionData['checkedServices'];
		    
		    // make sure, we have valid array
		    if (!is_array($this->checkedCategories))
		    {
		        $this->checkedCategories = [];
		    }
		    
		    if (!is_array($this->checkedServices))
		    {
		        $this->checkedServices = [];
		    }
			
			if (is_array($this->checkedCategories) && count($this->checkedCategories) > 0 && $this->sessionData['decision'] == 'agreed')
			{
			    foreach($this->settings['categories'] as $category => $categoryData)
			    {
			        // Collect all cookies and urls to remove
			        $this->collectData($category, in_array($category, $this->checkedCategories));
			    }
			}else if($this->getMode() == 'advanced')
			{
			    // If there is no cookie control data and the mode is
			    // advanced, then user did not give permission and so
			    // delete all cookies and remove all services
			    foreach($this->settings['categories'] as $category => $categoryData)
			    {
			        $this->collectData($category);
			    }
			}
		}else if($this->getMode() == 'advanced')
		{
		    // If there is no cookie control data and the mode is
		    // advanced, then user did not give permission and so
		    // delete all cookies and remove all services
		    foreach($this->settings['categories'] as $category => $categoryData)
		    {
		        $this->collectData($category);
		    }
		}
	}
	
	/**
	 * Remove cookies and disable external services from HTML.
	 * $inController->content has the HTML content
	 * @param array $inParams
     * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $inController
	 * @return void
	 */
	public function remove(&$inParams, &$inController)
	{
		// Make sure we are in the frontend
		if (TYPO3_MODE !== 'FE') {	
            return;
        }
        
        if ($this->isRemoveCookiesNecessary())
        {
        	// delete cookies
        	$this->removeCookies();
        }
        
        if ($this->isDisableServicesNecessary())
        {
        	$this->disableServices($inController->content);
        }
	}
	
	/**
	 * Collects cookies and services to delete/disable
	 * @param string|\Slavlee\SlavleeCookieControl\Domain\Model\Category $category
	 * @param boolean $isChecked
	 * @return void
	 */
	protected function collectData($category, $isChecked = FALSE)
	{
	    $services = [];
	    
		// collect services
	    $services = GeneralUtility::trimExplode(',', $this->settings['categories'][$category]['services'], true);
        
	    /**
	     * @var \Slavlee\SlavleeCookieControl\Domain\Model\Service $service
	     */
	    foreach($services as $service)
		{	
		    // Skip disabled services		    
		    if (!$this->settings['services'][$service]['enable'])
		    {
		        continue;
		    }
		    
		    $isServiceChecked = false;
		    
		    if(in_array($service, $this->checkedServices))
		    {
		        $isServiceChecked = true;
		    }
		    
		    if (!$isChecked && !$isServiceChecked)
		    {
		        $cookies = [];
		        
		        if(array_key_exists('cookies', $this->settings['services'][$service]))
		        {
		            $cookies = GeneralUtility::trimExplode(',', $this->settings['services'][$service]['cookies'], true);
		        }
		        
		        // collect cookies
		        if ($cookies)
		        {
		            foreach ($cookies as $cookie)
        		    {
        		        if (!in_array($cookie, $this->cookiesToRemove))
            			{
            				$this->cookiesToRemove[] = $cookie;
            			}
        		    }
		        }
		        
		        // collect urls
		        $urls = [];
		        
		        if(array_key_exists('urls', $this->settings['services'][$service]))
		        {
		            $urls = GeneralUtility::trimExplode(',', $this->settings['services'][$service]['urls'], true);
		        }
		        
		        if ($urls)
		        {
		            foreach($urls as $url)
    		        {
    		            if (!in_array($url, $this->urlsToDisable))
    		            {
    		                $this->urlsToDisable[] = $url;
    		            }
    		        }
		        }
		    }
		}
	}
	
	/**
	 * Disable services
	 * @param string $content
	 * @return void
	 */
	protected function disableServices(&$content)
	{
		$regex = '';
		$contentRollback = $content;  // save original html, for rollbacks
		
		foreach($this->urlsToDisable as $url)
		{
			if (!empty($regex))
			{
				$regex .= '|';
			}
			
			$regex .= RegexUtility::escapeRegexCharacters($url);
		}
		
		// Exclude area markes with /<!-- SCC_KEEP - START -->(.*)<!-- SCC_KEEP - END -->/s
		
		// First find all occurences with original code
		$exludeMatchesOriginal = [];		
		preg_match_all(self::REGEX_EXCLUDE_HTML_CODE, $content, $exludeMatchesOriginal, PREG_OFFSET_CAPTURE);
		
		$content = preg_replace('/' . $regex . '/', 'service.disabled', $content);
		
		// Then find again all occurences with changed code
		$exludeMatchesChanged = [];
		preg_match_all(self::REGEX_EXCLUDE_HTML_CODE, $content, $exludeMatchesChanged, PREG_OFFSET_CAPTURE);
		
		// Recover exluded html
		if (count($exludeMatchesOriginal) > 0 && count($exludeMatchesOriginal[0]) > 0 &&
		    count($exludeMatchesChanged) > 0 && count($exludeMatchesChanged[0]) > 0)
		{
		    foreach ($exludeMatchesChanged[0] as $key => $match)
    		{
    		    // Place the original code between the changed code
    		    $content = substr($content, 0, $match[1]) . $exludeMatchesOriginal[0][$key][0] . substr($content, $match[1] + strlen($match[0]));
    		}
		}else
		{
		    // if something went wrong, then revert changes
		    $content = $contentRollback;
		}
	}
	
	/**
	 * Return the current mode. Compatible Mode for Version below 2, because TS is different
	 * @return string
	 */
	protected function getMode()
	{
	    return is_array($this->settings['mode']) ? $this->settings['mode']['_typoScriptNodeValue'] : $this->settings['mode'];
	}
	
	/**
	 * Checks if hook shall disable services
	 * @return boolean
	 */
	protected function isDisableServicesNecessary()
	{
	    return count($this->urlsToDisable) > 0;
	}
	
	/**
	 * Checks if hook shall remove cookies
	 * @return boolean
	 */
	protected function isRemoveCookiesNecessary()
	{
		return count($this->cookiesToRemove) > 0;
	}
	
	/**
	 * Removes cookies
	 * @return void
	 */
	protected function removeCookies()
	{
		if (count($this->cookiesToRemove) > 0)
		{
			foreach($this->cookiesToRemove as $cookie)
			{
			    CookieUtility::delete($cookie);
			}
		}else {
			// if there is no list of cookies, but
			// user wants to disable cookies, then delete all
			CookieUtility::deleteAll(array(md5('Slavlee\SlavleeCookieControl\ViewHelpers\Widget\Controller\CategoriesController')));
		}
	}
	
	
}