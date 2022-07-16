<?php

declare(strict_types=1);

namespace Davtk\Forum\Infrastructure\Uuid;

use Davtk\Forum\Domain\UuidProvider;
use Ramsey\Uuid\Uuid;

class RamseyUuidV4 implements UuidProvider
{
    public function provide(): string
    {
        return (string) Uuid::uuid4();
    }
}
