<?php
declare(strict_types=1);
namespace Slavlee\SlavleeCookieControl\Service\Source;

use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;

abstract class AbstractSourceService
{
    /**
     * Build categories array with user decisions
     * @param array $sessionData
     * @return array
     */
    abstract public function buildCategoriesArrayWithDecisions($sessionData);
}