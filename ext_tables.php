<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Slavlee.SlavleeCookieControl',
            'Slavleecookiecontrol',
            'Slavlee Cookie Control'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('slavlee_cookie_control', 'Configuration/TypoScript', 'Slavlee Cookie Control');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_slavleecookiecontrol_domain_model_category', 'EXT:slavlee_cookie_control/Resources/Private/Language/locallang_csh_tx_slavleecookiecontrol_domain_model_category.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_slavleecookiecontrol_domain_model_category');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_slavleecookiecontrol_domain_model_cookie', 'EXT:slavlee_cookie_control/Resources/Private/Language/locallang_csh_tx_slavleecookiecontrol_domain_model_cookie.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_slavleecookiecontrol_domain_model_cookie');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_slavleecookiecontrol_domain_model_service', 'EXT:slavlee_cookie_control/Resources/Private/Language/locallang_csh_tx_slavleecookiecontrol_domain_model_service.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_slavleecookiecontrol_domain_model_service');

    },
    $_EXTKEY
);
