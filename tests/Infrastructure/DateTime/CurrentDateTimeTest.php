<?php

namespace Davtk\Forum\Infrastructure\DateTime;

use PHPUnit\Framework\TestCase;

class CurrentDateTimeTest extends TestCase
{

    public function testProvide(): void
    {
        $provider = new CurrentDateTime();

        // Not sure if there is some milliseconds or anything like that,
        // so instead of comparing objects I am comparing time
        $this->assertSame(
            (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
            $provider->provide()->format('Y-m-d H:i:s'),
        );
    }
}
