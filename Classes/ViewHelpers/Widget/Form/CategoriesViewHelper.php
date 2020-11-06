<?php
declare(strict_types=1);
namespace Slavlee\SlavleeCookieControl\ViewHelpers\Widget\Form;

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

class CategoriesViewHelper extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
{
	/**
	 * $controller
	 * @var \Slavlee\SlavleeCookieControl\ViewHelpers\Widget\Form\Controller\CategoriesController
	 */
	protected $controller;
	
	/**
	 * Initialize arguments.
	 * @internal
	 */
	public function initializeArguments()
	{
		parent::initializeArguments();
		$this->registerArgument('categories', 'array', 'List of categories from typoscript: settings.categories', true);
		$this->registerArgument('cookies', 'array', 'List of cookies settings from typoscript: settings.cookies', false, []);
		$this->registerArgument('services', 'array', 'List of services settings from typoscript: settings.services', false, []);
		$this->registerArgument('hide', 'boolean', 'Enable to hide the categories in the frontend.', false, false);
	}
	
	/**
	 * Inject $controller
	 * @param \Slavlee\SlavleeCookieControl\ViewHelpers\Widget\Form\Controller\CategoriesController $controller
	 */
	public function injectCategoriesController(\Slavlee\SlavleeCookieControl\ViewHelpers\Widget\Form\Controller\CategoriesController $controller)
	{
		$this->controller = $controller;
	}
	
	/**
	 * Render ViewHelper
	 * @return string
	 */
	public function render()
	{
		return $this->initiateSubRequest();
	}
}