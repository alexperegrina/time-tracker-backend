<?php
declare(strict_types=1);

namespace DegustaBox\Core\Domain\Messenger\Bus;

use DegustaBox\Core\Domain\Messenger\Message\Query;

interface QueryBus extends MessageBus
{
    public function dispatch(Query $query): mixed;
}