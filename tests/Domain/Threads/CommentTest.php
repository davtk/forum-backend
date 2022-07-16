<?php

namespace Davtk\Forum\Domain\Threads;

use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    private function getComment(): Comment
    {
        return new Comment(
            uuid: 'hello-world-comment',
            nickname: 'Nick',
            email: 'nick@mail.com',
            message: 'test comment',
            posted: new \DateTimeImmutable('2022-01-01 10:00'),
        );
    }

    public function testUuid(): void
    {
        $this->assertSame(
            'hello-world-comment',
            $this->getComment()->uuid(),
        );
    }

    public function testDetail(): void
    {
        $avatarProvider = new class implements AvatarProvider {
            public function getLink(string $email): string
            {
                return 'avatar_for_' . $email;
            }
        };

        $this->assertEquals(
            new CommentDetail(
                uuid: 'hello-world-comment',
                nickname: 'Nick',
                avatar_link: 'avatar_for_nick@mail.com',
                email: 'nick@mail.com',
                message: 'test comment',
                posted: new \DateTimeImmutable('2022-01-01 10:00'),
            ),
            $this->getComment()->toDetail(
                $avatarProvider,
            ),
        );
    }

    public function testJson(): void
    {
        $this->assertEquals(
            (object) [
                'uuid' => 'hello-world-comment',
                'nickname' => 'Nick',
                'email' => 'nick@mail.com',
                'message' => 'test comment',
                'posted' => '2022-01-01 10:00:00',
            ],
            $this->getComment()->jsonSerialize(),
        );
    }
}
