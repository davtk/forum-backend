<?php

declare(strict_types=1);

namespace Davtk\Forum\Domain\Threads;

use DateTimeImmutable;

class ThreadDetail
{
    /** @param CommentDetail[] $comments */
    public function __construct(
        public readonly string $uuid,
        public readonly string $topic,
        public readonly DateTimeImmutable $created,
        public readonly array $comments,
    ) {
    }
}
