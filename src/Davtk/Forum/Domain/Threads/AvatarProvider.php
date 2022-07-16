<?php

namespace Davtk\Forum\Domain\Threads;

interface AvatarProvider
{
    public function getLink(string $email);
}
