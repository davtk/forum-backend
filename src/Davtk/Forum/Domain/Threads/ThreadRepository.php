<?php

declare(strict_types=1);

namespace Davtk\Forum\Domain\Threads;

interface ThreadRepository
{
    /** @throws ThreadNotExists */
    public function get(string $uuid): Thread;

    /** @return array<Thread> */
    public function getAll(): array;

    public function persist(Thread $thread): void;
}
