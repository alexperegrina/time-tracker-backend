<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class TimeRecordingConfiguration implements ConfigurationInterface
{
    const ALIAS = 'time_recording';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        return new TreeBuilder(self::ALIAS);
    }
}