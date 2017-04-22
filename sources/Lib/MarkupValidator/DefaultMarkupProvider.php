<?php

namespace Kolyunya\Codeception\Lib\MarkupValidator;

use Exception;
use Codeception\Lib\ModuleContainer;
use Codeception\Module\PhpBrowser;
use Codeception\Module\WebDriver;
use Kolyunya\Codeception\Lib\MarkupValidator\MarkupProviderInterface;

/**
 * Default markup provider which attemps to get markup from
 * `PhpBrowser` and `WebDriver` modules.
 */
class DefaultMarkupProvider implements MarkupProviderInterface
{
    /**
     * Module container.
     *
     * @var ModuleContainer
     */
    private $moduleContainer;

    /**
     * Configuration parameters.
     *
     * @var array
     */
    private $config;

    /**
     * {@inheritDoc}
     */
    public function __construct(ModuleContainer $moduleContainer, array $config = array())
    {
        $this->moduleContainer = $moduleContainer;
        $this->config = $config;
    }

    /**
     * {@inheritDoc}
     */
    public function getMarkup()
    {
        try {
            return $this->getMarkupFromPhpBrowser();
        } catch (Exception $exception) {
            // Wasn't able to get markup from the `PhpBrowser` module.
        }

        try {
            return $this->getMarkupFromWebDriver();
        } catch (Exception $exception) {
            // Wasn't able to get markup from the `WebDriver` module.
        }

        throw new Exception('Unable to obtain current page markup.');
    }

    /**
     * Returns current page markup form the `PhpBrowser` module.
     *
     * @return string Current page markup.
     */
    private function getMarkupFromPhpBrowser()
    {
        $moduleName = 'PhpBrowser';
        if (!$this->moduleContainer->hasModule($moduleName)) {
            throw new Exception(sprintf('"%s" module is not enabled.', $moduleName));
        }

        /* @var $phpBrowser PhpBrowser */
        $phpBrowser = $this->moduleContainer->getModule($moduleName);
        $markup = $phpBrowser->_getResponseContent();

        return $markup;
    }

    /**
     * Returns current page markup form the `WebDriver` module.
     *
     * @return string Current page markup.
     */
    private function getMarkupFromWebDriver()
    {
        $moduleName = 'WebDriver';
        if (!$this->moduleContainer->hasModule($moduleName)) {
            throw new Exception(sprintf('"%s" module is not enabled.', $moduleName));
        }

        /* @var $webDriver WebDriver */
        $webDriver = $this->moduleContainer->getModule($moduleName);
        $markup = $webDriver->webDriver->getPageSource();

        return $markup;
    }
}
