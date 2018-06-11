<?php
namespace Vaimo\Codeception\Lib\MarkupValidator;

class DefaultMessageFilter extends \Vaimo\Codeception\Lib\Base\Component
    implements \Vaimo\Codeception\Lib\MarkupValidator\MessageFilterInterface
{
    const ERROR_COUNT_THRESHOLD_KEY = 'errorCountThreshold';
    const IGNORE_WARNINGS_CONFIG_KEY = 'ignoreWarnings';
    const IGNORED_ERRORS_CONFIG_KEY = 'ignoredErrors';

    /**
     * @var array
     */
    protected $configuration = array(
        self::ERROR_COUNT_THRESHOLD_KEY => 0,
        self::IGNORE_WARNINGS_CONFIG_KEY => true,
        self::IGNORED_ERRORS_CONFIG_KEY => array(),
    );

    protected $regexDelimiters = [
        '@', '$', ']', '}', '.', ',', '-', ')', '~', '>', '!', '&', '|', '/', '#', '?', ':', '_', '+', '=', '%', ';'
    ];

    public function determineDelimiter($value)
    {
        $subset = array_filter($this->regexDelimiters, function ($delimiter) use ($value) {
            return strpos($value, $delimiter) === false;
        });

        return reset($subset);
    }

    /**
     * {@inheritDoc}
     */
    public function filterMessages(array $messages)
    {
        $filteredMessages = array();

        $targetedTypes = array_filter(
            array(
                'ERROR' => true,
                'WARNING' => !$this->getConfigValue(self::IGNORE_WARNINGS_CONFIG_KEY, 'bool')
            )
        );

        $ignoredErrors = $this->getConfigValue(self::IGNORED_ERRORS_CONFIG_KEY, 'array');

        foreach ($messages as $message) {
            /* @var $message MarkupValidatorMessageInterface */
            $messageType = strtoupper($message->getType());

            if (!isset($targetedTypes[$messageType])) {
                continue;
            }

            if ($this->shouldIgnoreMessage($message, $ignoredErrors) === true) {
                continue;
            }

            $filteredMessages[] = $message;
        }

        if (count($messages) <= $this->getConfigValue(self::ERROR_COUNT_THRESHOLD_KEY, 'int')) {
            return array();
        }

        return $filteredMessages;
    }

    private function getConfigValue($key, $type)
    {
        if (call_user_func('is_' . $type, $this->configuration[$key]) === false) {
            throw new \Exception(
                sprintf('Invalid «%s» config key.', $key)
            );
        }

        return $this->configuration[$key];
    }

    /**
     * @param object $message
     * @param array $ignoredPatterns
     * @return boolean
     * @throws \Exception
     */
    private function shouldIgnoreMessage($message, array $ignoredPatterns)
    {
        $messageContentItems = array($message->getSummary(), $message->getMarkup());

        if (!trim(implode('', $messageContentItems))) {
            return false;
        }

        $messageContent = implode('|', $messageContentItems);

        foreach ($ignoredPatterns as $pattern) {
            $delimiter = $this->determineDelimiter($pattern);

            if (preg_match($delimiter . $pattern . $delimiter, $messageContent)) {
                return true;
            }
        }

        return false;
    }
}
