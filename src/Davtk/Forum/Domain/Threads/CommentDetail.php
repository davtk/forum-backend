<?php

declare(strict_types=1);

namespace Davtk\Forum\Domain\Threads;

use DateTimeImmutable;
use JsonSerializable;

class CommentDetail
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $nickname,
        public readonly string $avatar_link,
        public readonly string $email,
        public readonly string $message,
        public readonly DateTimeImmutable $posted,
    ) {
    }
}
