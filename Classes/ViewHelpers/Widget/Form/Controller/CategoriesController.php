<?php
declare(strict_types=1);
namespace Slavlee\SlavleeCookieControl\ViewHelpers\Widget\Form\Controller;

use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

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

class CategoriesController extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetController
{
	/**
	 * $categories, Categories from settings.categories
	 * @var array
	 */
	protected $categories;
	
	/**
	 * $cookies, Categories from settings.cookies
	 * @var array
	 */
	protected $cookies;
	
	/**
	 * $services, Services from settings.services
	 * @var array
	 */
	protected $services;
	
	/**
	 * $hide
	 * @var boolean
	 */
	protected $hide;
	
	/**
	 * $sessionData, cookie consent data for current frontend user
	 * @var array
	 */
	protected $sessionData;
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \TYPO3\CMS\Extbase\Mvc\Controller\ActionController::initializeAction()
	 */
	public function initializeAction()
	{
		$this->categories = $this->widgetConfiguration['categories'];
		$this->cookies = $this->widgetConfiguration['cookies'];
		$this->services = $this->widgetConfiguration['services'];
		$this->hide = $this->widgetConfiguration['hide'];
		$this->sessionData = \Slavlee\SlavleeCookieControl\Utility\GeneralUtility::getCategorySettingsFromSession();
	}
	
	/**
	 * Render a form where user can enable/disable cookies categories
	 * @return string
	 */
	public function indexAction()
	{
		$this->processForm();
		$categories = [];
		
		/**
		 * @var \Slavlee\SlavleeCookieControl\Service\Source\SourceTypoScriptService $service
		 */
		$service = $this->objectManager->get(\Slavlee\SlavleeCookieControl\Service\Source\SourceTypoScriptService::class, $this->categories, $this->services, $this->cookies);
		$categories = $service->buildCategoriesArrayWithDecisions($this->sessionData);
		
		$this->view->assign('source', $this->source);
		$this->view->assign('hide', $this->hide);
		$this->view->assign('categories', $categories);
		$this->view->assign('contentObject', $this->configurationManager->getContentObject()->data);
	}		
	
		
	
	/**
	 * Checks if form has been submitted, if so then save chosen categories
	 * @return void
	 */
	protected function processForm()
	{		
		if (!is_array($this->sessionData))
		{
			return;
		}
		
		if(array_key_exists('decision', $this->sessionData) && $this->sessionData['decision'] == 'agreed')
		{
			// save selected categories, if user decision was to accept cookies
		    if(array_key_exists('categorySettingsKey', $this->sessionData))
			{
				// if exsits, then save selected categories
			    $this->sessionData['checkedCategories'] = $this->sessionData['categorySettingsKey'];
			}						
			
			// save selected service, if user decision was to accept cookies
			if(array_key_exists('categoryServiceSettingsKey', $this->sessionData))
			{
			    // if exsits, then save selected categories
			    $this->sessionData['checkedServices'] = $this->sessionData['categoryServiceSettingsKey'];
			}
		}elseif(array_key_exists('decision', $this->sessionData) && $myData['decision'] == 'disagreed')
		{
			//if user decision was to disable cookies, then automatically disable all selections
		    $this->sessionData['checkedCategories'] = [];
		    $this->sessionData['checkedServices'] = [];
		}
		
		// save data in session
		\Slavlee\SlavleeCookieControl\Utility\GeneralUtility::saveCategorySettingsToSession($this->sessionData);
	}		
}