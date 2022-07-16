<?php

namespace Davtk\Forum\Infrastructure\Avatar;

use PHPUnit\Framework\TestCase;

class GravatarProviderTest extends TestCase
{

    public function testGetLink(): void
    {
        $gravatar = new GravatarProvider();

        $this->assertSame(
            'https://gravatar.com/avatar/97dfebf4098c0f5c16bca61e2b76c373?d=robohash',
            $gravatar->getLink('test@mail.com'),
        );
    }
}
