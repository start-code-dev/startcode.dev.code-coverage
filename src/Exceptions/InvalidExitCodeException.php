<?php

namespace Startcode\CodeCoverage\Exceptions;

use Startcode\CodeCoverage\ErrorCodes;
use Startcode\CodeCoverage\ExitCode;

class InvalidExitCodeException extends \Exception
{

    const MESSAGE = 'Invalid exit code value: %s (valid: %s, %s)';

    public function __construct($exitCodeValue)
    {
        parent::__construct(
            sprintf(self::MESSAGE, $exitCodeValue, ExitCode::SUCCESS, ExitCode::ERROR),
            ErrorCodes::INVALID_EXIT_CODE_EXCEPTION
        );
    }
}
