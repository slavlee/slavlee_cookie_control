<?php
declare(strict_types=1);
namespace Slavlee\SlavleeCookieControl\Utility;

use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

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

class GeneralUtility
{
	/**
	 * Returns the categories setting from the session
	 * @return array | FALSE if none
	 */
	static public function getCategorySettingsFromSession()
	{
		$myData = $GLOBALS['TSFE']->fe_user->getKey('ses', md5('Slavlee\SlavleeCookieControl\ViewHelpers\Widget\Controller\CategoriesController'));
		
		return $myData ? $myData : CookieUtility::getCookie(md5('Slavlee\SlavleeCookieControl\ViewHelpers\Widget\Controller\CategoriesController'));
	}
	
	/**
	 * Returns the current TypoScript Settings of the plugin
	 * @return array
	 */
	static public function getTypoScriptSettings()
	{
		$allTS = self::loadAllTypoScriptSettings();
		
		if (isset($allTS['page.']))
		{
			foreach($allTS['page.'] as $tsProperty)
			{
				if (is_array($tsProperty) && 
					isset($tsProperty['extensionName']) && $tsProperty['extensionName'] == 'SlavleeCookieControl' && 
					isset($tsProperty['vendorName']) && $tsProperty['vendorName'] == 'Slavlee')
				{
					$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectManager::class);
					/**
					 * 
					 * @var \TYPO3\CMS\Core\TypoScript\TypoScriptService $typoScriptService
					 */
					$typoScriptService = $objectManager->get(\TYPO3\CMS\Core\TypoScript\TypoScriptService::class);
					return $typoScriptService->convertTypoScriptArrayToPlainArray($tsProperty['settings.']);
				}
			}
		}
		
		return FALSE;
	}
	
	/**
	 * Get All TypoScript Settings for this page
	 */
	static public function loadAllTypoScriptSettings() {
		$pageUid = $GLOBALS['TSFE']->id;
		$rootLine = '';
		
		if (floatval(TYPO3_branch) >= 10.0)
		{
		    $rootLine = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Utility\RootlineUtility::class, $pageUid);
		    $rootLine = $rootLine->get();
		}else
		{
    		/** @var \TYPO3\CMS\Frontend\Page\PageRepository $sysPageObj */
    		$sysPageObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Frontend\Page\PageRepository');
    		$rootLine = $sysPageObj->getRootLine($pageUid);
		}
		
		/** @var \TYPO3\CMS\Core\TypoScript\ExtendedTemplateService $TSObj */
		$TSObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\TypoScript\ExtendedTemplateService');
		$TSObj->tt_track = 0;
		
		if (floatval(TYPO3_branch) < 10.0)
		{
		  $TSObj->init();
		}
		
		$TSObj->runThroughTemplates($rootLine);
		$TSObj->generateConfig();
	
		return $TSObj->setup;
	}
	
	/**
	 * Saves category settings to session
	 * @param mixed $data
	 * @return void
	 */
	static public function saveCategorySettingsToSession($data)
	{
		// Save data in session. We need to do this, because the current
		// decision is not available in $_COOKIE in this request, but in the next
		$GLOBALS['TSFE']->fe_user->setKey('ses', md5('Slavlee\SlavleeCookieControl\ViewHelpers\Widget\Controller\CategoriesController'), $data);
		
		// Persist data in cookie. We need to do this, because when
		// session cookie is disabled it gets deleted and data would be loss
		CookieUtility::setCookie(md5('Slavlee\SlavleeCookieControl\ViewHelpers\Widget\Controller\CategoriesController'), $data, time()+60*60*24*365);	
	}
}