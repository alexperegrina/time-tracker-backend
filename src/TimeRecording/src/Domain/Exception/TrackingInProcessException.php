<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Domain\Exception;

use Exception;

class TrackingInProcessException extends Exception
{
    public function __construct()
    {
        parent::__construct("Tracking in process");
    }
}