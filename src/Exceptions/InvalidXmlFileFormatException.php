<?php

namespace Startcode\CodeCoverage\Exceptions;

use Exception;
use Startcode\CodeCoverage\ErrorCodes;
use Startcode\ValueObject\RealPath;

class InvalidXmlFileFormatException extends Exception
{

    const MESSAGE = 'Invalid XML file format in file: %s';

    public function __construct(RealPath $configPath)
    {
        parent::__construct(
            sprintf(self::MESSAGE, (string) $configPath),
            ErrorCodes::INVALID_XML_FILE_FORMAT_EXCEPTION
        );
    }
}
