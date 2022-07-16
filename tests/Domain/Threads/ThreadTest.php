<?php

namespace Davtk\Forum\Domain\Threads;

use PHPUnit\Framework\TestCase;

class ThreadTest extends TestCase
{
    private function getAvatarProvider(): AvatarProvider
    {
        return new class implements AvatarProvider {
            public function getLink(string $email): string
            {
                return 'avatar_for_' . $email;
            }
        };
    }

    public function testDetail(): void
    {
        $thread = new Thread(
            uuid: 'my-awesome-thread',
            topic: 'My awesome thread',
            created: new \DateTimeImmutable('2022-01-01 10:00'),
        );

        $this->assertEquals(
            new ThreadDetail(
                uuid: 'my-awesome-thread',
                topic: 'My awesome thread',
                created: new \DateTimeImmutable('2022-01-01 10:00'),
                comments: [],
            ),
            $thread->toDetail(
                $this->getAvatarProvider(),
            ),
        );
    }

    public function testAddComment(): void
    {
        $thread = new Thread(
            uuid: 'my-awesome-thread',
            topic: 'My awesome thread',
            created: new \DateTimeImmutable('2022-01-01 10:00'),
        );

        $comment = new Comment(
            uuid: 'hello-world-comment',
            nickname: 'Nick',
            email: 'nick@mail.com',
            message: 'test comment',
            posted: new \DateTimeImmutable('2022-01-01 10:00'),
        );

        $thread->addComment($comment);

        $this->assertEquals(
            new ThreadDetail(
                uuid: 'my-awesome-thread',
                topic: 'My awesome thread',
                created: new \DateTimeImmutable('2022-01-01 10:00'),
                comments: [
                    new CommentDetail(
                        uuid: 'hello-world-comment',
                        nickname: 'Nick',
                        avatar_link: 'avatar_for_nick@mail.com',
                        email: 'nick@mail.com',
                        message: 'test comment',
                        posted: new \DateTimeImmutable('2022-01-01 10:00'),
                    ),
                ],
            ),
            $thread->toDetail(
                $this->getAvatarProvider(),
            ),
        );
    }
}
