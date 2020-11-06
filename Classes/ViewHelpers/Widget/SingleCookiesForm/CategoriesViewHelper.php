<?php
declare(strict_types=1);
namespace Slavlee\SlavleeCookieControl\ViewHelpers\Widget\SingleCookiesForm;

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
	 * @var \Slavlee\SlavleeCookieControl\ViewHelpers\Widget\SingleCookiesForm\Controller\CategoriesController
	 */
	protected $controller;
	
	/**
	 * Initialize arguments.
	 * @internal
	 */
	public function initializeArguments()
	{
		parent::initializeArguments();
		$this->registerArgument('categories', 'array', 'List of categories to display.', true);
		$this->registerArgument('cookies', 'array', 'List of cookies settings from typoscript: settings.cookies', false, []);
		$this->registerArgument('services', 'array', 'List of services settings from typoscript: settings.services', false, []);
	}
	
	/**
	 * Inject $controller
	 * @param \Slavlee\SlavleeCookieControl\ViewHelpers\Widget\SingleCookiesForm\Controller\CategoriesController $controller
	 */
	public function injectCategoriesController(\Slavlee\SlavleeCookieControl\ViewHelpers\Widget\SingleCookiesForm\Controller\CategoriesController $controller)
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