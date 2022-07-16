<?php

declare(strict_types=1);

namespace Davtk\Forum\Infrastructure\Nette\Presenters\Schema\Response;

use JsonSerializable;

final class StatusDto implements JsonSerializable
{
    public const STATUS_ERROR = 'error';
    public const STATUS_OK = 'ok';

    public function __construct(
        public readonly string $status,
        public readonly string $message,
    ) {
    }

    public static function internal(): self
    {
        return new self(self::STATUS_ERROR, 'internal error');
    }

    public static function notFound(): self
    {
        return new self(self::STATUS_ERROR, 'resource not found');
    }

    public static function unknown(): self
    {
        return new self(self::STATUS_ERROR, 'unknown state');
    }

    public function jsonSerialize(): object
    {
        return (object) [
            'status' => $this->status,
            'message' => $this->message,
        ];
    }
}
