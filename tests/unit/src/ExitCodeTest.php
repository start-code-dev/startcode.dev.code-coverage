<?php


use Startcode\CodeCoverage\ExitCode;
use Startcode\CodeCoverage\Exceptions\InvalidExitCodeException;

class ExitCodeTest extends PHPUnit_Framework_TestCase
{

    public function testError()
    {
        $exitCode = ExitCode::error();
        $this->assertInstanceOf(ExitCode::class, $exitCode);
        $this->assertEquals(1, $exitCode->getValue());
    }

    public function testSuccess()
    {
        $exitCode = ExitCode::success();
        $this->assertInstanceOf(ExitCode::class, $exitCode);
        $this->assertEquals(0, $exitCode->getValue());
    }

    public function testValidValue()
    {
        $exitCode = new ExitCode(1);

        $this->assertEquals(1, $exitCode->getValue());
    }

    public function testInvalidValue()
    {
        $this->expectException(InvalidExitCodeException::class);
        new ExitCode(5);
    }

}
