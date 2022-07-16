<?php

declare(strict_types=1);

namespace Davtk\Forum\Domain;

interface UuidProvider
{
    public function provide(): string;
}
