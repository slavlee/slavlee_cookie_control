<?php
declare(strict_types=1);
namespace Slavlee\SlavleeCookieControl\ExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

class CookiesAcceptConditionFunctionsProvider implements ExpressionFunctionProviderInterface
{
	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface::getFunctions()
	 */
    public function getFunctions()
    {
        return [
            $this->getCookiesAcceptedFunction(),
            $this->getCategoryAcceptedFunction(),
            $this->getServiceAcceptedFunction()
        ];
    }

    /**
     * Execute expression language function to check for set cookies
     * @return ExpressionFunction
     * @deprecated the wording is not precise, because you don't accept to certain cookies. Please replace with categoryAccepted(), which does the same. This function will be deleted in the future.
     */
    protected function getCookiesAcceptedFunction(): ExpressionFunction
    {
    	return new ExpressionFunction('cookiesAccepted', function () {
    		// Not implemented, we only use the evaluator
    	}, function ($existingVariables, $categoryIndex = '') {
	    	if ($GLOBALS['TSFE']->fe_user)
			{
				$data = $GLOBALS['TSFE']->fe_user->getKey('ses', md5('Slavlee\SlavleeCookieControl\ViewHelpers\Widget\Controller\CategoriesController'));
				
				if (!empty($categoryIndex))
				{
					return is_array($data) && array_key_exists('decision', $data) && $data['decision'] == 'agreed' && in_array($categoryIndex, $data['categorySettingsKey']);
				}else {
					return is_array($data) && array_key_exists('decision', $data) && $data['decision'] == 'agreed';
				}						
			}
			return FALSE;
    	});
    }
    
    /**
     * Execute expression language function to check if given category was accepted
     * @return ExpressionFunction
     */
    protected function getCategoryAcceptedFunction(): ExpressionFunction
    {
        return new ExpressionFunction('categoryAccepted', function () {
            // Not implemented, we only use the evaluator
        }, function ($existingVariables, $categoryIndex = '') {
            if ($GLOBALS['TSFE']->fe_user)
            {
                $data = $GLOBALS['TSFE']->fe_user->getKey('ses', md5('Slavlee\SlavleeCookieControl\ViewHelpers\Widget\Controller\CategoriesController'));
                
                if (!empty($categoryIndex))
                {
                    return is_array($data) && array_key_exists('decision', $data) && $data['decision'] == 'agreed' && in_array($categoryIndex, $data['categorySettingsKey']);
                }
            }
            return FALSE;
        });
    }
    
    /**
     * Execute expression language function to check if given service was accepted
     * @return ExpressionFunction
     */
    protected function getServiceAcceptedFunction(): ExpressionFunction
    {
        return new ExpressionFunction('serviceAccepted', function () {
            // Not implemented, we only use the evaluator
        }, function ($existingVariables, $serviceUid = '') {
            if ($GLOBALS['TSFE']->fe_user)
            {
                $data = $GLOBALS['TSFE']->fe_user->getKey('ses', md5('Slavlee\SlavleeCookieControl\ViewHelpers\Widget\Controller\CategoriesController'));
                
                if (!empty($serviceUid))
                {
                    return is_array($data) && array_key_exists('decision', $data) && $data['decision'] == 'agreed' && in_array($serviceUid, $data['categoryServiceSettingsKey']);
                }
            }
            return FALSE;
        });
    }
}