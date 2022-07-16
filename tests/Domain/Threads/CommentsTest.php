<?php

namespace Davtk\Forum\Domain\Threads;

use PHPUnit\Framework\TestCase;

class CommentsTest extends TestCase
{
    public function testGetAll(): void
    {
        $comment1 = new Comment(
            uuid: 'hello-world-comment',
            nickname: 'Nick',
            email: 'nick@mail.com',
            message: 'test comment',
            posted: new \DateTimeImmutable('2022-01-01 10:00'),
        );

        $comments = new Comments([$comment1]);

        $this->assertSame(
            expected: [$comment1],
            actual: $comments->getAll(),
        );
    }

    public function testByUuid(): void
    {
        $comment1 = new Comment(
            uuid: 'hello-world-comment',
            nickname: 'Nick',
            email: 'nick@mail.com',
            message: 'test comment',
            posted: new \DateTimeImmutable('2022-01-01 10:00'),
        );

        $comment2 = new Comment(
            uuid: 'goodbye-world-comment',
            nickname: 'Nick',
            email: 'nick@mail.com',
            message: 'second comment',
            posted: new \DateTimeImmutable('2022-01-02 20:00'),
        );

        $comments = new Comments([$comment1, $comment2]);

        $this->assertSame(
            $comment2,
            $comments->byUuid('goodbye-world-comment'),
        );
    }

    public function testAdd(): void
    {
        $comment1 = new Comment(
            uuid: 'hello-world-comment',
            nickname: 'Nick',
            email: 'nick@mail.com',
            message: 'test comment',
            posted: new \DateTimeImmutable('2022-01-01 10:00'),
        );

        $comment2 = new Comment(
            uuid: 'goodbye-world-comment',
            nickname: 'Nick',
            email: 'nick@mail.com',
            message: 'second comment',
            posted: new \DateTimeImmutable('2022-01-02 20:00'),
        );

        $comments = new Comments([$comment1]);
        $newInstance = $comments->add($comment2);

        $this->assertSame(
            expected: [$comment1],
            actual: $comments->getAll(),
            message: 'Verify immutability of collection',
        );

        $this->assertNotSame(
            $newInstance,
            $comments,
        );

        $this->assertSame(
            expected: [$comment1, $comment2],
            actual: $newInstance->getAll(),
            message: 'Verify add comment to collection',
        );
    }

    public function testDuplicate(): void
    {
        $comment1 = new Comment(
            uuid: 'hello-world-comment',
            nickname: 'Nick',
            email: 'nick@mail.com',
            message: 'test comment',
            posted: new \DateTimeImmutable('2022-01-01 10:00'),
        );

        $comments = new Comments([$comment1]);

        $this->expectException(CommentAlreadyExists::class);
        $comments->add($comment1);
    }
}
