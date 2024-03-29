<?php

namespace Startcode\CodeCoverage;

use Startcode\ValueObject\Dictionary;
use Startcode\ValueObject\IntegerNumber;

class MetricsFactory
{

    /**
     * @var IntegerNumber
     */
    private $requiredPercentage;

    /**
     * @var Dictionary
     */
    private $metricsData;

    /**
     * MetricsFactory constructor.
     * @param \SimpleXMLElement $xmlData
     * @param IntegerNumber $requiredPercentage
     */
    public function __construct(\SimpleXMLElement $xmlData, IntegerNumber $requiredPercentage)
    {
        $this->metricsData          = $this->convertToDictionary($xmlData);
        $this->requiredPercentage   = $requiredPercentage;
    }

    /**
     * @return Metrics
     */
    public function create()
    {
        return new Metrics(
            new MetricsData(
                new IntegerNumber((int) $this->metricsData->get(ParamsConsts::METHODS)),
                new IntegerNumber((int) $this->metricsData->get(ParamsConsts::COVEREDMETHODS))
            ),
            new MetricsData(
                new IntegerNumber((int) $this->metricsData->get(ParamsConsts::STATEMENTS)),
                new IntegerNumber((int) $this->metricsData->get(ParamsConsts::COVEREDSTATEMENTS))
            ),
            new MetricsData(
                new IntegerNumber((int) $this->metricsData->get(ParamsConsts::ELEMENTS)),
                new IntegerNumber((int) $this->metricsData->get(ParamsConsts::COVEREDELEMENTS))
            ),
            $this->requiredPercentage
        );
    }

    /**
     * @param \SimpleXMLElement $xmlData
     * @return Dictionary
     */
    private function convertToDictionary(\SimpleXMLElement $xmlData)
    {
        $data = [];
        foreach ($xmlData->project->metrics->attributes() as $atribute) {
            $data[$atribute->getName()] = (string) $atribute;
        }
        return new Dictionary($data);
    }
}
