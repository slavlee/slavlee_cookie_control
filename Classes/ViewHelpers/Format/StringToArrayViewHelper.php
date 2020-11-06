<?php
declare(strict_types = 1);
namespace Slavlee\SlavleeCookieControl\ViewHelpers\Format;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class StringToArrayViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    protected $escapeOutput = false;
    protected $escapeChildren = false;
    
    /**
     * 
     * {@inheritDoc}
     * @see \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper::initializeArguments()
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
    
        $this->registerArgument('string', 'string', 'If set, then this string will be used to convert, otherwise the body part', false, '');
        $this->registerArgument('as', 'string', 'If set, then the resulting array will be available under this variable in the body part', false, ''); 
    }

    /**
     * Render ViewHelper
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return void
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
        $string = $arguments['string'];
        
        if (empty($arguments['string']))
        {
            $string = $renderChildrenClosure();
        }
        
        $array = GeneralUtility::trimExplode(PHP_EOL, $string, true);
        
        if (!empty($arguments['as']))
        {
            $renderingContext->getVariableProvider()->add($arguments['as'], $array);
            return $renderChildrenClosure();
        }
        
        return $array;
    }
}