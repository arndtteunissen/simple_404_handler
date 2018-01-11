<?php

/*
 * Copyright notice
 *
 * (c) 2017 arndtteunissen <dev@arndtteunissen.de>
 * All rights reserved
 */

defined('TYPO3_MODE') || die();

call_user_func(function ($extKey) {

    // Read extension configuration
    $extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extKey]);

    // Enable error handling
    if (is_array($extConf) && $extConf['404page'] > 0) {
        $GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling'] = 'USER_FUNCTION:' . \Arndtteunissen\Simple404Handler\UserFunc\Page::class . '->pageNotFound';
    }

}, $_EXTKEY);
