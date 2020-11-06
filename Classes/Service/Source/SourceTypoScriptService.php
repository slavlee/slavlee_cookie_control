<?php
declare(strict_types=1);
namespace Slavlee\SlavleeCookieControl\Service\Source;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class SourceTypoScriptService extends AbstractSourceService
{
    /**
     * $categoriesFromTS
     * @var array
     */
    protected $categoriesFromTS;
    
    /**
     * $servicesFromTS
     * @var array
     */
    protected $servicesFromTS;
    
    /**
     * $cookiesFromTS
     * @var array
     */
    protected $cookiesFromTS;
    
    /**
     * Create a SourceTypoScriptService
     * @param array $categoriesFromTS
     * @param array $servicesFromTS
     * @param array $cookiesFromTS
     * @return void
     */
    public function __construct(array $categoriesFromTS, array $servicesFromTS, array $cookiesFromTS)
    {
        $this->categoriesFromTS = $categoriesFromTS;
        $this->servicesFromTS = $servicesFromTS;
        $this->cookiesFromTS = $cookiesFromTS;
    }
    
    /**
     * Build categories array with user decisions
     * @param array $sessionData
     * @return array
     */
    public function buildCategoriesArrayWithDecisions($sessionData)
    {
        $categories = array();
        
        foreach($this->categoriesFromTS as $catSettingsKey => $catSettings)
        {
            if($processed = $this->processCatSettings($catSettings))
            {
                $processed['checked'] = FALSE;
                
                if ($this->isCatSettingsChecked($catSettingsKey, $sessionData) || $processed['mandatory'])
                {
                    $processed['checked'] = TRUE;
                }
                
                $hasCheckedServices = FALSE;
                $processed['services'] = $this->processCatServices(GeneralUtility::trimExplode(',', $catSettings['services'], TRUE), $processed['checked'], $hasCheckedServices, $sessionData);
                $processed['hasCheckedServices'] = $hasCheckedServices;
                $categories[$catSettingsKey] = $processed;
            }
        }
        
        return $categories;
    }
    
    /**
     * Check if the given service was checked
     * @param string $service
     * @param array $sessionData
     * @return boolean
     */
    public function checkServiceIfChecked($service, array &$sessionData)
    {
        if (!is_array($sessionData['checkedServices']))
        {
            return false;
        }
        return in_array($service, $sessionData['checkedServices']) && $sessionData['decision'] == 'agreed';
    }
    
    /**
     * Checks if a category settings is checked
     * @param int $catSettingsKey
     * @param array $sessionData
     * @return boolean
     */
    public function isCatSettingsChecked($catSettingsKey, array &$sessionData)
    {
        if (is_array($sessionData) &&
            array_key_exists('decision', $sessionData) &&
            $sessionData['decision'] == 'agreed' &&
            array_key_exists('checkedCategories', $sessionData) &&
            in_array($catSettingsKey, $sessionData['checkedCategories']))
        {
            return TRUE;
        }
        return FALSE;
    }
    
    /**
     * Convert categorie TypoScript settings for view
     * @param array $catSettings
     * @return array | FALSE
     */
    protected function processCatSettings(array $catSettings)
    {
        $processed = FALSE;
        
        if (is_array($catSettings) &&
            array_key_exists('label', $catSettings) &&
            array_key_exists('services', $catSettings) &&
            array_key_exists('enable', $catSettings) &&
            $catSettings['enable'] &&
            strlen(trim($catSettings['label'])) > 0 &&
            strlen(trim($catSettings['services'])) > 0)
        {
            $processed = $catSettings;
            $processed['mandatory'] =  array_key_exists('mandatory', $catSettings) ? $catSettings['mandatory'] : 0;
            $processed['urls'] = GeneralUtility::trimExplode(',', $catSettings['urls'], TRUE);
        }
        
        return $processed;
    }
    
    /**
     * Create service array with all informations including cookies
     * @param array $services
     * @param boolean $forceChecked
     * @param boolean $hasCheckedServices, is TRUE if at least one service was checked
     * @param array $sessionData
     * @return array
     */
    protected function processCatServices(array $services, $forceChecked = FALSE, &$hasCheckedServices = FALSE, array &$sessionData)
    {
        $pServices = [];
        
        if (count($services) > 0)
        {
            foreach($services as $key => $service)
            {
                if (array_key_exists($service, $this->servicesFromTS))
                {
                    if ($this->servicesFromTS[$service]['enable'])
                    {
                        $pServices[$key] = $this->servicesFromTS[$service];
                        $pServices[$key]['id'] = strtolower($service);
                        $pServices[$key]['cookies'] = [];
                        $pServices[$key]['urls'] = GeneralUtility::trimExplode(',', $this->servicesFromTS[$service]['urls'], TRUE);
                        
                        if ($forceChecked && $sessionData['decision'] == 'agreed')
                        {
                            $pServices[$key]['checked'] = $forceChecked;
                        }else
                        {
                            $pServices[$key]['checked'] = $this->checkServiceIfChecked($service, $sessionData);
                            
                            if(!$hasCheckedServices && $pServices[$key]['checked'])
                            {
                                $hasCheckedServices = $pServices[$key]['checked'];
                            }
                        }
                        
                        if (array_key_exists('cookies', $this->servicesFromTS[$service]))
                        {
                            $cookies = GeneralUtility::trimExplode(',', $this->servicesFromTS[$service]['cookies'], TRUE);
                            
                            foreach($cookies as $cookie)
                            {
                                if (array_key_exists($cookie, $this->cookiesFromTS))
                                {
                                    $pServices[$key]['cookies'][$cookie] = $this->cookiesFromTS[$cookie];
                                }
                            }
                        }
                    }
                }
            }
        }
        
        return $pServices;
    }	
}