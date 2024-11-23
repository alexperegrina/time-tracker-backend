<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Application\Query\FindTasksByUser;

use DegustaBox\Core\Domain\Messenger\Message\Query;

readonly class FindTasksByUserQuery implements Query
{
    public function __construct(public string $id) {}
}