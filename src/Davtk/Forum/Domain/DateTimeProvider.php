<?php

declare(strict_types=1);

namespace Davtk\Forum\Domain;

use DateTimeImmutable;

interface DateTimeProvider
{
    public function provide(): DateTimeImmutable;
}
