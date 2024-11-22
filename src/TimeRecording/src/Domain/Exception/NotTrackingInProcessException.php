<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Domain\Exception;

use Exception;

class NotTrackingInProcessException extends Exception
{
    public function __construct()
    {
        parent::__construct("Not tracking in process");
    }
}