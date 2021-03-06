<?php
namespace Vaimo\Codeception\Lib\Base;

abstract class Component implements \Vaimo\Codeception\Lib\Base\ComponentInterface
{
    /**
     * Component configuration array.
     *
     * @var array
     */
    protected $configuration = array();

    /**
     * {@inheritDoc}
     */
    public static function getClassName()
    {
        $className = get_called_class();

        return $className;
    }

    /**
     * Constructs a component. Sets component configuration.
     *
     * @param array $configuration Component configuration array.
     */
    public function __construct(array $configuration = array())
    {
        $this->setConfiguration($configuration);
    }

    /**
     * {@inheritDoc}
     */
    public function setConfiguration(array $configuration)
    {
        $this->configuration = array_merge($this->configuration, $configuration);
    }
}
