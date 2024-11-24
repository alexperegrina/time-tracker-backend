<?php
declare(strict_types=1);

namespace DegustaBox\Core\Domain\Exception;

use Exception;

class InvalidPathException extends Exception
{
    public function __construct(public readonly string $path)
    {
        $message = [
            'message' => 'Invalid path',
            'path' => $this->path,
        ];
        parent::__construct(json_encode($message));
    }
}