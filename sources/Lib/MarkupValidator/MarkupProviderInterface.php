<?php

namespace Kolyunya\Codeception\Lib\MarkupValidator;

use Codeception\Lib\ModuleContainer;

/**
 * An interface of a markup provider.
 */
interface MarkupProviderInterface
{
    /**
     * Constructs a markup provider. Injects a module container and configuration parameters.
     *
     * @param ModuleContainer $moduleContainer Module container.
     * @param array $config Configuration parameters.
     */
    public function __construct(ModuleContainer $moduleContainer, array $config);

    /**
     * Returns page markup.
     *
     * @return string Page markup.
     */
    public function getMarkup();
}
