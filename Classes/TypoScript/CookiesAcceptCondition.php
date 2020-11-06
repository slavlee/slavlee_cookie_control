<?php
declare(strict_types=1);
namespace Slavlee\SlavleeCookieControl\TypoScript;

use TYPO3\CMS\Core\Configuration\TypoScript\ConditionMatching\AbstractCondition;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Context\Context;

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
 * 
 * @author Kevin Chileong Lee
 * @deprecated the wording is not precise, because you don't accept to certain cookies. Please replace with Slavlee\SlavleeCookieControl\TypoScript\CategoryAcceptCondition, which does the same. This function will be deleted in the future.
 */
class CookiesAcceptCondition extends AbstractCondition
{
	/**
	 * 
	 * {@inheritDoc}
	 * @see \TYPO3\CMS\Core\Configuration\TypoScript\ConditionMatching\AbstractCondition::matchCondition()
	 */
	public function matchCondition(array $conditionParameters)
	{
		if ($GLOBALS['TSFE']->fe_user)
		{
			$data = $GLOBALS['TSFE']->fe_user->getKey('ses', md5('Slavlee\SlavleeCookieControl\ViewHelpers\Widget\Controller\CategoriesController'));
			return is_array($data) && array_key_exists('decision', $data) && $data['decision'] == 'agreed';
		}
		
		return FALSE;
	}
}