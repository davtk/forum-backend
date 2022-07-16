<?php

namespace Davtk\Forum\Infrastructure\Avatar;

use Davtk\Forum\Domain\Threads\AvatarProvider;

class GravatarProvider implements AvatarProvider
{

    public function getLink(string $email): string
    {
        return 'https://gravatar.com/avatar/' . md5($email) . '?d=robohash';
    }
}
