<?php
namespace Arndtteunissen\Simple404Handler\UserFunc;

/*
 * Copyright notice
 *
 * (c) 2017 arndtteunissen <dev@arndtteunissen.de>
 * All rights reserved
 */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Class Page
 */
class Page
{
    /**
     * @param array $conf
     * @param TyposcriptFrontendController $ref
     * @throws \RuntimeException
     */
    public function pageNotFound($conf, $ref)
    {
        $pageUid        = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['simple_404_handler']['404page'];
        $sysLanguageUid = $this->emitSysLanguageUid();

        $url = $this->makeAbsoluteUri(
            sprintf(
                'index.php?id=%s&L=%s&nocache=1',
                $pageUid,
                $sysLanguageUid
            )
        );

        $error = [];
        $response = GeneralUtility::getUrl(
            $url,
            false,
            [
                'Referer: ' . $conf['currentUrl']
            ],
            $error
        );

        if ($response) {
            echo $response;
        } else {
            throw new \RuntimeException(sprintf("Couldn't show error page. Subrequest for '%s' failed. Reason (%s): %s", $url, $error['error'], $error['message']) , 1511191687, $error['exception']);
        }
    }

    /**
     * Make absolute uri from relative uri.
     *
     * @param string $path
     * @return string
     * @throws \UnexpectedValueException
     */
    protected function makeAbsoluteUri($path)
    {
        $absoluteUrlScheme = GeneralUtility::getIndpEnv('TYPO3_SSL') ? 'https' : 'http';
        $siteUrl = GeneralUtility::getIndpEnv('HTTP_HOST');
        $siteUrl .= rtrim(GeneralUtility::getIndpEnv('TYPO3_SITE_PATH'), '/');

        return sprintf('%s://%s/%s', $absoluteUrlScheme, $siteUrl, ltrim($path, '/'));
    }

    /**
     * Emit the current sysLanguageUid
     *
     * @return int
     */
    protected function emitSysLanguageUid()
    {
        $sysLanguageUid = 0;

        if (ExtensionManagementUtility::isLoaded('realurl')) {
            try {
                $config = $this->getRealurlConfig();

                if ((int)GeneralUtility::_GP('L') > 0) {
                    $sysLanguageUid = (int)GeneralUtility::_GP('L');
                } elseif (is_array($config) && isset($config['preVars']) && is_array($config['preVars'])) {
                    $requestUri = trim(GeneralUtility::getIndpEnv('REQUEST_URI'), '/');
                    $requestUri = substr($requestUri, strlen(GeneralUtility::getIndpEnv('TYPO3_SITE_PATH')) - 1);
                    $uriParts   = explode('/', $requestUri);
                    $language   = array_shift($uriParts);

                    foreach ($config['preVars'] as $preVarConfig) {
                        if (isset($preVarConfig['GETvar']) && $preVarConfig['GETvar'] === 'L' && isset($preVarConfig['valueMap'][$language])) {
                            $sysLanguageUid = (int)$preVarConfig['valueMap'][$language];
                        }
                    }
                } else {
                    $sysLanguageUid = (int)GeneralUtility::_GP('L');
                }
            } catch (\UnexpectedValueException $e) {
                return 0;
            }
        } else {
            $sysLanguageUid = (int)GeneralUtility::_GP('L');
        }

        return $sysLanguageUid;
    }

    /**
     * Pull realurl configuration
     *
     * @return array|false
     * @throws \UnexpectedValueException
     */
    protected function getRealurlConfig()
    {
        $config    = false;
        $sysConfig = false;

        if (isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']) && is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl'])) {
            $sysConfig = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl'];
        } else {
            if (isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl'])) {
                try {
                    $sysConfig = (array)unserialize($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']);
                } catch (\Exception $e) {
                    $sysConfig = false;
                }
            }
        }

        if (is_array($sysConfig)) {
            $domain = GeneralUtility::getIndpEnv('HTTP_HOST');

            if (isset($sysConfig[$domain])) {
                $config = $sysConfig[$domain];
            } else {
                if (isset($sysConfig['_DEFAULT'])) {
                    $config = $sysConfig['_DEFAULT'];
                }
            }
        }

        return $config;
    }
}