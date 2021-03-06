<?php

namespace Vaimo\Codeception\Tests\Lib\MarkupValidator;

use Vaimo\Codeception\Lib\MarkupValidator\DefaultMessagePrinter;
use Vaimo\Codeception\Lib\MarkupValidator\MarkupValidatorMessage;
use Vaimo\Codeception\Lib\MarkupValidator\MarkupValidatorMessageInterface;
use PHPUnit\Framework\TestCase;

class DefaultMessagePrinterTest extends TestCase
{
    /**
     * @var DefaultMessagePrinter
     */
    private $printer;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $this->printer = new DefaultMessagePrinter();
    }

    /**
     * {@inheritDoc}
     */
    public function tearDown()
    {
    }

    /**
     * @dataProvider testGetMessageStringDataProvider
     */
    public function testGetMessageString($message, $stringExpected)
    {
        $stringActual = $this->printer->getMessageString($message);
        $this->assertEquals($stringExpected, $stringActual);
    }

    /**
     * @dataProvider testGetMessagesStringDataProvider
     */
    public function testGetMessagesString(array $messages, $stringExpected)
    {
        $stringActual = $this->printer->getMessagesString($messages);
        $this->assertEquals($stringExpected, $stringActual);
    }

    public function testGetMessageStringDataProvider()
    {
        return array(
            array(
                (new MarkupValidatorMessage())
                ,
                <<<TXT
Markup validator message:
Type: undefined
Summary: unavailable
Details: unavailable
First Line: unavailable
Last Line: unavailable
Markup: unavailable

TXT
                ,
            ),
            array(
                (new MarkupValidatorMessage())
                    ->setType(MarkupValidatorMessageInterface::TYPE_UNDEFINED)
                ,
                <<<TXT
Markup validator message:
Type: undefined
Summary: unavailable
Details: unavailable
First Line: unavailable
Last Line: unavailable
Markup: unavailable

TXT
                ,
            ),
            array(
                (new MarkupValidatorMessage())
                    ->setType(MarkupValidatorMessageInterface::TYPE_ERROR)
                    ->setSummary('Short error summary.')
                    ->setDetails('Detailed error description.')
                    ->setFirstLineNumber(103)
                    ->setLastLineNumber(105)
                    ->setMarkup('<html></html>')
                ,
                <<<TXT
Markup validator message:
Type: error
Summary: Short error summary.
Details: Detailed error description.
First Line: 103
Last Line: 105
Markup: <html></html>

TXT
                ,
            ),
        );
    }

    public function testGetMessagesStringDataProvider()
    {
        return array(
            array(
                array(
                    (new MarkupValidatorMessage())
                    ,
                    (new MarkupValidatorMessage())
                        ->setType(MarkupValidatorMessageInterface::TYPE_UNDEFINED)
                    ,
                    (new MarkupValidatorMessage())
                        ->setType(MarkupValidatorMessageInterface::TYPE_ERROR)
                        ->setSummary('Short error summary.')
                        ->setDetails('Detailed error description.')
                        ->setFirstLineNumber(103)
                        ->setLastLineNumber(105)
                        ->setMarkup('<html></html>')
                    ,
                ),
                <<<TXT
Markup validator message:
Type: undefined
Summary: unavailable
Details: unavailable
First Line: unavailable
Last Line: unavailable
Markup: unavailable

Markup validator message:
Type: undefined
Summary: unavailable
Details: unavailable
First Line: unavailable
Last Line: unavailable
Markup: unavailable

Markup validator message:
Type: error
Summary: Short error summary.
Details: Detailed error description.
First Line: 103
Last Line: 105
Markup: <html></html>

TXT
                ,
            ),
            array(
                array(
                    (new MarkupValidatorMessage())
                        ->setType(MarkupValidatorMessageInterface::TYPE_UNDEFINED)
                    ,
                    (new MarkupValidatorMessage())
                        ->setType(MarkupValidatorMessageInterface::TYPE_ERROR)
                        ->setSummary('Short error summary.')
                        ->setDetails('Detailed error description.')
                        ->setFirstLineNumber(103)
                        ->setLastLineNumber(105)
                        ->setMarkup('<html></html>')
                    ,
                ),
                <<<TXT
Markup validator message:
Type: undefined
Summary: unavailable
Details: unavailable
First Line: unavailable
Last Line: unavailable
Markup: unavailable

Markup validator message:
Type: error
Summary: Short error summary.
Details: Detailed error description.
First Line: 103
Last Line: 105
Markup: <html></html>

TXT
                ,
            ),
            array(
                array(
                    (new MarkupValidatorMessage())
                        ->setType(MarkupValidatorMessageInterface::TYPE_ERROR)
                        ->setSummary('Short error summary.')
                        ->setDetails('Detailed error description.')
                        ->setFirstLineNumber(103)
                        ->setLastLineNumber(105)
                        ->setMarkup('<html></html>')
                    ,
                ),
                <<<TXT
Markup validator message:
Type: error
Summary: Short error summary.
Details: Detailed error description.
First Line: 103
Last Line: 105
Markup: <html></html>

TXT
                ,
            ),
            array(
                array(
                ),
                <<<TXT
TXT
                ,
            ),
        );
    }
}
