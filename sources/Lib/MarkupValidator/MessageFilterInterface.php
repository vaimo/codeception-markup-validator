<?php

namespace Vaimo\Codeception\Lib\MarkupValidator;

use Vaimo\Codeception\Lib\Base\ComponentInterface;
use Vaimo\Codeception\Lib\MarkupValidator\MarkupValidatorMessageInterface;

/**
 * An interface of a markup validator message filter.
 */
interface MessageFilterInterface extends ComponentInterface
{
    /**
     * Constructs a message filter. Injects configuration parameters.
     *
     * @param array $config Configuration parameters.
     */
    public function __construct(array $config);

    /**
     * Filters and returns messages.
     *
     * @param MarkupValidatorMessageInterface[] $messages Messages to filter.
     *
     * @return MarkupValidatorMessageInterface[] Filtered messages.
     */
    public function filterMessages(array $messages);
}
