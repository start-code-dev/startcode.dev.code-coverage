<?php

namespace Startcode\CodeCoverage;

use Questocat\ConsoleColor\ConsoleColor;
use Startcode\ValueObject\IntegerNumber;
use Startcode\ValueObject\RealPath;
use Garden\Cli\Args;

class Runner
{

    /**
     * @var Args
     */
    private $args;

    /**
     * Runner constructor.
     * @param Args $args
     */
    public function __construct(Args $args)
    {
        $this->args = $args;
    }

    public function run()
    {
        $xml        = $this->makeReader()->read();
        $metrics    = $this->makeMetrics($xml);
        $presenter  = $this->makePresenter($metrics);

        $metrics->meetsTheCondition()
            ? $presenter->stdOut()
            : $presenter->stdErr();
    }

    /**
     * @return Reader
     */
    public function makeReader()
    {
        return new Reader(new RealPath($this->args->getOpt(ParamsConsts::FILE)));
    }

    /**
     * @param \SimpleXMLElement $xml
     * @return Metrics
     */
    public function makeMetrics(\SimpleXMLElement $xml)
    {
        $factory = new MetricsFactory(
            $xml,
            new IntegerNumber($this->args->getOpt(ParamsConsts::PERCENTAGE))
        );
        return $factory->create();
    }

    /**
     * @param Metrics $metrics
     * @return Presenter
     */
    public function makePresenter(Metrics $metrics)
    {
        return new Presenter($metrics, new Console(new ConsoleColor()));
    }
}
