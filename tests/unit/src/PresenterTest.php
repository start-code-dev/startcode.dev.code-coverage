<?php


use Startcode\CodeCoverage\{Presenter, Console, Metrics, MetricsFormatter};
use Startcode\ValueObject\StringLiteral;

class PresenterTest extends PHPUnit\Framework\TestCase
{

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $consoleMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $metricsMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $metricsFormatterMock;

    /**
     * @var Presenter
     */
    private $presenter;


    public function testMakeMetricsFormatter()
    {
        $this->assertInstanceOf(MetricsFormatter::class, $this->presenter->makeMetricsFormatter());
    }

    public function testStdErr()
    {
        $this->metricsFormatterMock->expects($this->once())->method('format')->willReturn(['message0', 'message1']);

        $this->presenterMock->expects($this->once())->method('makeMetricsFormatter')->willReturn($this->metricsFormatterMock);

        $this->consoleMock->expects($this->exactly(2))->method('putsErr');

        $this->consoleMock->expects($this->once())->method('exitWithCode');

        $this->presenterMock->stdErr();
    }

    public function testStdOut()
    {
        $this->metricsFormatterMock->expects($this->once())->method('format')->willReturn(['message0']);

        $this->presenterMock->expects($this->once())->method('makeMetricsFormatter')->willReturn($this->metricsFormatterMock);

        $this->consoleMock->expects($this->once())->method('putsOut');

        $this->consoleMock->expects($this->once())->method('exitWithCode');

        $this->presenterMock->stdOut();
    }

    protected function setUp() : void
    {
        $this->metricsMock = $this->getMockBuilder(Metrics::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->consoleMock = $this->getMockBuilder(Console::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->metricsFormatterMock = $this->getMockBuilder(MetricsFormatter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->presenter = new Presenter($this->metricsMock, $this->consoleMock);

        $this->presenterMock = $this->getMockBuilder(Presenter::class)
            ->setConstructorArgs([$this->metricsMock, $this->consoleMock])
            ->setMethods(['makeMetricsFormatter'])
            ->getMock();
    }

    protected function tearDown() : void
    {
        $this->metricsMock              = null;
        $this->consoleMock              = null;
        $this->metricsFormatterMock     = null;
        $this->presenter                = null;
        $this->presenterMock            = null;
    }
}
