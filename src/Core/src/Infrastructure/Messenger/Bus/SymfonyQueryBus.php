<?php
declare(strict_types=1);

namespace DegustaBox\Core\Infrastructure\Messenger\Bus;

use DegustaBox\Core\Domain\Messenger\Bus\QueryBus;
use DegustaBox\Core\Domain\Messenger\Message\Query;

class SymfonyQueryBus extends SymfonyMessageBus implements QueryBus
{
    public function dispatch(Query $query): mixed
    {
        return $this->dispatchMessage($query);
    }
}