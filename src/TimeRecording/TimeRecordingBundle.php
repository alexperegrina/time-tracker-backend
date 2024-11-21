<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording;

use DegustaBox\TimeRecording\DependencyInjection\TimeRecordingExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class TimeRecordingBundle extends Bundle
{
    protected function getContainerExtensionClass(): string
    {
        return TimeRecordingExtension::class;
    }
}