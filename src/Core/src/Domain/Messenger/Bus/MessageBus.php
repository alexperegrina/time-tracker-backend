<?php
declare(strict_types=1);

namespace DegustaBox\Core\Domain\Messenger\Bus;

interface MessageBus
{
    public function messages(): array;
}