<?php
declare(strict_types=1);
namespace Slavlee\SlavleeCookieControl\ExpressionLanguage;

use TYPO3\CMS\Core\ExpressionLanguage\AbstractProvider;

/***
 *
 * This file is part of the "slavlee_cookie_control" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Kevin Chileong Lee <support@slavlee.de>, Slavlee
 *
 ***/

class CookiesAcceptConditionProvider extends AbstractProvider
{
	/**
	 * Create a CookiesAcceptCondition
	 * @return void
	 */
	public function __construct()
	{
		$this->expressionLanguageProviders = [
            CookiesAcceptConditionFunctionsProvider::class,
        ];
	}
}