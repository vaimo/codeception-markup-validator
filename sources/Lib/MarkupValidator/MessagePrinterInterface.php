<?php

namespace Vaimo\Codeception\Lib\MarkupValidator;

use Vaimo\Codeception\Lib\Base\ComponentInterface;
use Vaimo\Codeception\Lib\MarkupValidator\MarkupValidatorMessageInterface;

/**
 * An interface of a markup validator message printer.
 */
interface MessagePrinterInterface extends ComponentInterface
{
    /**
     * Returns a string representation of a single message.
     *
     * @return string A string representation of a single message.
     */
    public function getMessageString(MarkupValidatorMessageInterface $message);

    /**
     * Returns a string representation of multiple message.
     *
     * @return string A string representation of multiple message.
     */
    public function getMessagesString(array $messages);
}
