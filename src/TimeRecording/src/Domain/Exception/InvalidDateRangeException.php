<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Domain\Exception;

use Exception;

class InvalidDateRangeException extends Exception
{
    public function __construct()
    {
        parent::__construct('The start date cannot be greater than the end date');
    }
}