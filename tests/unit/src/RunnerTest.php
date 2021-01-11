<?php

use Garden\Cli\Args;
use Startcode\CodeCoverage\{Runner, Reader, Metrics, Presenter};

class RunnerTest extends PHPUnit\Framework\TestCase
{

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $argsMock;

    /**
     * @var Runner
     */
    private $runner;


    public function testMakeReader()
    {
        $this->argsMock->expects($this->once())
            ->method('getOpt')
            ->will($this->onConsecutiveCalls('tests/unit/fixtures/code-coverage.xml'));

        $this->assertInstanceOf(Reader::class, $this->runner->makeReader());
    }

    public function testMakeMetrics()
    {
        $this->argsMock->expects($this->once())
            ->method('getOpt')
            ->will($this->onConsecutiveCalls(90));

        $xml = simplexml_load_file('tests/unit/fixtures/code-coverage.xml');

        $this->assertInstanceOf(Metrics::class, $this->runner->makeMetrics($xml));
    }

    public function testMakePresenter()
    {
        $metricsMock = $this->getMockBuilder(Metrics::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->assertInstanceOf(Presenter::class, $this->runner->makePresenter($metricsMock));
    }

    public function testRun()
    {
        $xml = simplexml_load_file('tests/unit/fixtures/code-coverage.xml');

        $readerMock = $this->getMockBuilder(Reader::class)
            ->disableOriginalConstructor()
            ->getMock();

        $readerMock->expects($this->once())->method('read')->willReturn($xml);

        $metricsMock = $this->getMockBuilder(Metrics::class)
            ->disableOriginalConstructor()
            ->getMock();

        $metricsMock->expects($this->once())->method('meetsTheCondition')->willReturn(true);

        $presenterMock = $this->getMockBuilder(Presenter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $presenterMock->expects($this->once())->method('stdOut');

        $runnerMock = $this->getMockBuilder(Runner::class)
            ->disableOriginalConstructor()
            ->setMethods(['makeReader', 'makeMetrics', 'makePresenter'])
            ->getMock();

        $runnerMock->expects($this->once())->method('makeReader')->willReturn($readerMock);
        $runnerMock->expects($this->once())->method('makeMetrics')->with($xml)->willReturn($metricsMock);
        $runnerMock->expects($this->once())->method('makePresenter')->willReturn($presenterMock);

        $runnerMock->run();
    }

    protected function setUp() : void
    {
        $this->argsMock = $this->getMockBuilder(Args::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->runner = new Runner($this->argsMock);
    }

    protected function tearDown() : void
    {
        $this->argsMock = null;
        $this->runner   = null;
    }
}
