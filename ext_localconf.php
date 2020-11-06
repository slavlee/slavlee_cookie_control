<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Slavlee.SlavleeCookieControl',
            'Slavleecookiecontrol',
            [
                'CookieControl' => 'show, form, singleCookiesForm, simpleMode, advancedMode'
            ],
            // non-cacheable actions
            [
                'CookieControl' => 'show, form, singleCookiesForm, simpleMode, advancedMode'
            ]
        );

        // wizards
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            'mod {
                wizards.newContentElement.wizardItems.plugins {
                    elements {
                        slavleecookiecontrol {
                            iconIdentifier = slavlee_cookie_control-plugin-slavleecookiecontrol
                            title = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang_db.xlf:tx_slavlee_cookie_control_slavleecookiecontrol.name
                            description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang_db.xlf:tx_slavlee_cookie_control_slavleecookiecontrol.description
                            tt_content_defValues {
                                CType = list
                                list_type = slavleecookiecontrol_slavleecookiecontrol
                            }
                        }
                    }
                    show = *
                }
           }'
        );
		$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
		
		$iconRegistry->registerIcon(
			'slavlee_cookie_control-plugin-slavleecookiecontrol',
			\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
			['source' => 'EXT:slavlee_cookie_control/Resources/Public/Icons/user_plugin_slavleecookiecontrol.svg']
		);
		
		/**
		 * hook is called before Caching / pages on their way in the cache.
		 */
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = 'Slavlee\SlavleeCookieControl\Hooks\CookieRemoverHook->remove';
		
    },
    $_EXTKEY
);
