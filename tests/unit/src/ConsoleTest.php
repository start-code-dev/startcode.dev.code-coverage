<?php


use Startcode\CodeCoverage\Console;
use Questocat\ConsoleColor\ConsoleColor;

class ConsoleTest extends PHPUnit\Framework\TestCase
{

    public function testConstruct()
    {
        $consoleColorMock = $this->getMockBuilder(ConsoleColor::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->assertInstanceOf(Console::class, new Console($consoleColorMock));
    }
}
