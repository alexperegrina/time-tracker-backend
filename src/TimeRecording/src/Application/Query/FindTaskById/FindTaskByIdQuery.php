<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Application\Query\FindTaskById;

use DegustaBox\Core\Domain\Messenger\Message\Query;

readonly class FindTaskByIdQuery implements Query
{
    public function __construct(public string $id)
    {}
}