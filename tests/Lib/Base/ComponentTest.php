<?php

namespace Vaimo\Codeception\Tests\Lib\Base;

use Vaimo\Codeception\Lib\Base\Component;
use Vaimo\Codeception\Lib\MarkupValidator\DefaultMarkupProvider;
use Vaimo\Codeception\Lib\MarkupValidator\DefaultMessageFilter;
use Vaimo\Codeception\Lib\MarkupValidator\DefaultMessagePrinter;
use Vaimo\Codeception\Lib\MarkupValidator\W3CMarkupValidator;
use PHPUnit\Framework\TestCase;

class ComponentTest extends TestCase
{
    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function tearDown()
    {
    }

    /**
     * @dataProvider testGetClassNameDataProvider
     */
    public function testGetClassName($classNameActual, $classNameExpected)
    {
        $this->assertEquals($classNameActual, $classNameExpected);
    }

    public function testGetClassNameDataProvider()
    {
        return array(
            array(
                'Vaimo\Codeception\Lib\Base\Component',
                Component::getClassName(),
            ),
            array(
                'Vaimo\Codeception\Lib\MarkupValidator\DefaultMarkupProvider',
                DefaultMarkupProvider::getClassName(),
            ),
            array(
                'Vaimo\Codeception\Lib\MarkupValidator\DefaultMessageFilter',
                DefaultMessageFilter::getClassName(),
            ),
            array(
                'Vaimo\Codeception\Lib\MarkupValidator\DefaultMessagePrinter',
                DefaultMessagePrinter::getClassName(),
            ),
            array(
                'Vaimo\Codeception\Lib\MarkupValidator\W3CMarkupValidator',
                W3CMarkupValidator::getClassName(),
            ),
        );
    }
}
