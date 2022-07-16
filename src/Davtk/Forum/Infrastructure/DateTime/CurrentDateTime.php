<?php

declare(strict_types=1);

namespace Davtk\Forum\Infrastructure\DateTime;

use DateTimeImmutable;
use Davtk\Forum\Domain\DateTimeProvider;

class CurrentDateTime implements DateTimeProvider
{
    public function provide(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
