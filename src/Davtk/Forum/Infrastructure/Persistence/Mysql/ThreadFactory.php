<?php

declare(strict_types=1);

namespace Davtk\Forum\Infrastructure\Persistence\Mysql;

use DateTimeImmutable;
use Davtk\Forum\Domain\Threads\Comment;
use Davtk\Forum\Domain\Threads\Comments;
use Davtk\Forum\Domain\Threads\Thread;
use ReflectionClass;

class ThreadFactory
{
    public function create(array $data): Thread
    {
        $reflection = new ReflectionClass(Thread::class);
        $thread = $reflection->newInstanceWithoutConstructor();
        assert($thread instanceof Thread);

        $reflection->getProperty('uuid')->setValue($thread, $data['uuid']);
        $reflection->getProperty('topic')->setValue($thread, $data['topic']);
        $reflection->getProperty('created')->setValue($thread, new DateTimeImmutable($data['created']));

        $reflection->getProperty('comments')->setValue($thread, new Comments(
            array_map(
                callback: static fn (array $comment) => new Comment(
                    uuid: $comment['uuid'],
                    nickname: $comment['nickname'],
                    email: $comment['email'],
                    message: $comment['message'],
                    posted: new DateTimeImmutable($comment['posted']),
                ),
                array: json_decode($data['comments'], true, 512, JSON_THROW_ON_ERROR),
            )
        ));

        return $thread;
    }
}
