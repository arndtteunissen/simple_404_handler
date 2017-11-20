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
    if (!is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extKey])) {
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extKey] = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extKey]);
    }

}, $_EXTKEY);
