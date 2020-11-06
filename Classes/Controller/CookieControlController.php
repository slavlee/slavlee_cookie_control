<?php
declare(strict_types=1);
namespace Slavlee\SlavleeCookieControl\Controller;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use Slavlee\SlavleeCookieControl\Utility\CookieUtility;
use TYPO3\CMS\Core\Utility\DebugUtility;
use Slavlee\SlavleeCookieControl\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use Slavlee\SlavleeCookieControl\Utility\TypoScriptSettingsUtility;

/***
 *
 * This file is part of the "SlavleeCookieControl" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Kevin Chileong Lee <support@slavlee.de>, Slavlee
 *
 ***/

/**
 * CookieControlController
 */
class CookieControlController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{	
    protected $extensionName = 'slavlee_cookie_control';
    
	/**************************************************************************
	 * INIT - START
	 **************************************************************************/
	/**
	 * 
	 * {@inheritDoc}
	 * @see \TYPO3\CMS\Extbase\Mvc\Controller\ActionController::initializeAction()
	 */
	protected function initializeAction()
	{
		if ($this->settings['include']['jQuery'])
		{
		    if (floatval(TYPO3_branch) >= 10.0)
		    {
		        $GLOBALS['TSFE']->additionalHeaderData['tx_slavlee_cookie_control'] = '<script src="' . \TYPO3\CMS\Core\Utility\PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath('slavlee_cookie_control')) . 'Resources/Public/jQuery/js/jquery-3.5.1.min.js" type="text/javascript"></script>';
		    }else if (floatval(TYPO3_branch) < 8.4)
			{
				$GLOBALS['TSFE']->additionalHeaderData['tx_slavlee_cookie_control'] = '<script src="' . ExtensionManagementUtility::extRelPath('slavlee_cookie_control') . 'Resources/Public/jQuery/js/jquery-3.5.1.min.js" type="text/javascript"></script>';
			}else
			{
				$GLOBALS['TSFE']->additionalHeaderData['tx_slavlee_cookie_control'] = '<script src="' . ExtensionManagementUtility::siteRelPath('slavlee_cookie_control') . 'Resources/Public/jQuery/js/jquery-3.5.1.min.js" type="text/javascript"></script>';
			}
		}
		
		if ($this->settings['include']['Popper'])
		{
		    if (floatval(TYPO3_branch) >= 10.0)
		    {
		        $GLOBALS['TSFE']->additionalHeaderData['tx_slavlee_cookie_control'] .= '<script src="' . \TYPO3\CMS\Core\Utility\PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath('slavlee_cookie_control')) . 'Resources/Public/Popper/popper.min.js" type="text/javascript"></script>';
		    }else if (floatval(TYPO3_branch) < 8.4)
			{
				$GLOBALS['TSFE']->additionalHeaderData['tx_slavlee_cookie_control'] .= '<script src="' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('slavlee_cookie_control') . 'Resources/Public/Popper/popper.min.js" type="text/javascript"></script>';
			}else
			{
				$GLOBALS['TSFE']->additionalHeaderData['tx_slavlee_cookie_control'] .= '<script src="' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath('slavlee_cookie_control') . 'Resources/Public/Popper/popper.min.js" type="text/javascript"></script>';
			}
		}
		
		if ($this->settings['include']['Bootstrap4'])
		{			
		    if (floatval(TYPO3_branch) >= 10.0)
		    {
		        $GLOBALS['TSFE']->additionalHeaderData['tx_slavlee_cookie_control'] .= '<link rel="stylesheet" type="text/css" href="' . \TYPO3\CMS\Core\Utility\PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath('slavlee_cookie_control')) . 'Resources/Public/Bootstrap/css/bootstrap.min.css" media="screen">';
		        $GLOBALS['TSFE']->additionalHeaderData['tx_slavlee_cookie_control'] .= '<script src="' . \TYPO3\CMS\Core\Utility\PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath('slavlee_cookie_control')) . 'Resources/Public/Bootstrap/js/bootstrap.min.js" type="text/javascript" async="async"></script>';
		    }elseif (floatval(TYPO3_branch) < 8.4)
			{
				$GLOBALS['TSFE']->additionalHeaderData['tx_slavlee_cookie_control'] .= '<link rel="stylesheet" type="text/css" href="' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('slavlee_cookie_control') . 'Resources/Public/Bootstrap/css/bootstrap.min.css" media="screen">';
				$GLOBALS['TSFE']->additionalHeaderData['tx_slavlee_cookie_control'] .= '<script src="' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('slavlee_cookie_control') . 'Resources/Public/Bootstrap/js/bootstrap.min.js" type="text/javascript" async="async"></script>';
			}else
			{
				$GLOBALS['TSFE']->additionalHeaderData['tx_slavlee_cookie_control'] .= '<link rel="stylesheet" type="text/css" href="' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath('slavlee_cookie_control') . 'Resources/Public/Bootstrap/css/bootstrap.min.css" media="screen">';
				$GLOBALS['TSFE']->additionalHeaderData['tx_slavlee_cookie_control'] .= '<script src="' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath('slavlee_cookie_control') . 'Resources/Public/Bootstrap/js/bootstrap.min.js" type="text/javascript" async="async"></script>';
			}
		}
	}
	/**************************************************************************
	 * INIT - END
	 **************************************************************************/
	
    /**************************************************************************
     * ACTIONS - START
     **************************************************************************/
	/**
	 * Advanced Mode: User can decide if he wants to use cookies
	 * @return string
	 */
	public function advancedModeAction()
	{
		$myData = GeneralUtility::getCategorySettingsFromSession();
		
		$this->view->assign('mode', 'advanced');			
		$this->view->assign('minify', is_array($myData) && array_key_exists('decision', $myData) && $myData['mode'] == $this->getMode() ? TRUE : FALSE);
	}
	
	/**
     * action show
     * 
     * @return void
     */
    public function showAction()
    {
    	switch($this->getMode())
    	{
    		case 'advanced':
    			$this->forward('advancedMode');
    			break;
    		default:
    			$this->forward('simpleMode');
    			break;
    	}    	
    }
    
    /**
     * Simple Mode: User get a closeable cookie alert with optional link to the privacy page
     * @return string
     */
    public function simpleModeAction()
    {
    	$myData = GeneralUtility::getCategorySettingsFromSession();
    	$this->view->assign('mode', 'simple');
    	$this->view->assign('minify', is_array($myData) && array_key_exists('decision', $myData) && $myData['mode'] == $this->getMode() ? TRUE : FALSE);
    }
    
    /**
     * action accept
     *
     * @param string $decision
     * @param string $mode
     * @param array categorySettingsKey
     * @return void
     */
    public function formAction($decision, $mode, $categorySettingsKey = [])
    {
    	$myData = GeneralUtility::getCategorySettingsFromSession();
    	
    	if (($mode == 'advanced' && $decision == LocalizationUtility::translate('slavlee_cookie_control.form.agree', $this->extensionName)) ||
    		($mode == 'simple' && $decision == LocalizationUtility::translate('slavlee_cookie_control.alert.gotit', $this->extensionName)))
    	{
    		// If user agree cookies, then save it to the session cookie,
    		// so that other extensions can react on it
    		$myData['decision'] = 'agreed';
    		$myData['categorySettingsKey'] = $categorySettingsKey;
    	}elseif($GLOBALS['TSFE']->fe_user->getKey('ses', 'slavlee_cookie_control') != 'disagreed') 
    	{
    		// default behavour is to not agree
    		$myData['decision'] = 'disagreed';
    		$myData['categorySettingsKey'] = [];
    	}
    	
    	$myData['mode'] = $mode;
    	
    	GeneralUtility::saveCategorySettingsToSession($myData);
        
    	$uri = $this->uriBuilder->reset()
    				->setTargetPageUid($GLOBALS['TSFE']->id)
    				->setCreateAbsoluteUri(TRUE)
    				->setNoCache(true)
    				->build();
		$this->redirectToUri($uri);
    }
    
    /**
     * action accept
     *
     * @param array categorySettingsKey
     * @param array $categoryServiceSettingsKey
     * @return void
     */
    public function singleCookiesFormAction($categorySettingsKey = [], $categoryServiceSettingsKey = [])
    {
        $myData = GeneralUtility::getCategorySettingsFromSession();
        
        // Save settings from singleCookiesForm
        $myData['decision'] = 'agreed';
        $myData['categorySettingsKey'] = $categorySettingsKey;
        $myData['categoryServiceSettingsKey'] = $categoryServiceSettingsKey;        
        $myData['mode'] = 'advanced';
        
        GeneralUtility::saveCategorySettingsToSession($myData);
        
        $uri = $this->uriBuilder->reset()
        ->setTargetPageUid($GLOBALS['TSFE']->id)
        ->setCreateAbsoluteUri(TRUE)
        ->setNoCache(true)
        ->build();
        $this->redirectToUri($uri);
    }
    /**************************************************************************
     * ACTIONS - END
     **************************************************************************/
    /**************************************************************************
     * HELPER - START
     **************************************************************************/
    /**
     * Return the current mode. Compatible Mode for Version below 2, because TS is different
     * @return string
     */
    protected function getMode()
    {
        return is_array($this->settings['mode']) ? $this->settings['mode']['_typoScriptNodeValue'] : $this->settings['mode'];
    }
    /**************************************************************************
     * HELPER - END
     **************************************************************************/
}
