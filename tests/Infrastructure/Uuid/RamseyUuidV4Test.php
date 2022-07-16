<?php

namespace Davtk\Forum\Infrastructure\Uuid;

use PHPUnit\Framework\TestCase;

class RamseyUuidV4Test extends TestCase
{

    public function testProvide(): void
    {
        $provider = new RamseyUuidV4();
        //78127fc2-48da-4329-a89b-d30fbfc21e9a

        $this->assertMatchesRegularExpression(
            '/[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12}/',
            $provider->provide(),
        );
    }
}
