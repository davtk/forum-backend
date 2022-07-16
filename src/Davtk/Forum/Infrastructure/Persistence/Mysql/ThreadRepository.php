<?php

declare(strict_types=1);

namespace Davtk\Forum\Infrastructure\Persistence\Mysql;

use Davtk\Forum\Domain\Threads\Thread;
use Davtk\Forum\Domain\Threads\ThreadNotExists;
use JsonException;
use PDO;
use ReflectionClass;

class ThreadRepository implements \Davtk\Forum\Domain\Threads\ThreadRepository
{
    public function __construct(
        private readonly PDO $connection,
        private readonly ThreadFactory $threadFactory,
    ) {
    }

    /**
     * @throws ThreadNotExists
     * @throws JsonException
     */
    public function get(string $uuid): Thread
    {
        $stmt = $this->connection->prepare('
            SELECT * 
            FROM thread
            WHERE uuid = :uuid
        ');

        $stmt->execute([
            'uuid' => $uuid,
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $this->threadFactory->create($result);
        }

        throw new ThreadNotExists();
    }

    public function getAll(): array
    {
        $threads = $this->connection->query('
            SELECT *
            FROM thread
            ORDER BY created DESC 
        ')->fetchAll(PDO::FETCH_ASSOC);

        $result = [];

        foreach ($threads as $thread) {
            $result[] = $this->threadFactory->create($thread);
        }

        return $result;
    }

    public function persist(Thread $thread): void
    {
        $stmt = $this->connection->prepare('
            INSERT INTO thread (uuid, topic, created, comments)
            VALUES (
                :uuid,
                :topic,
                :created,
                :comments
            )
            ON DUPLICATE KEY UPDATE
                topic = :topic,
                created = :created,
                comments = :comments
        ');

        $object = new ReflectionClass($thread);

        $stmt->execute([
            'uuid' => $object->getProperty('uuid')->getValue($thread),
            'topic' => $object->getProperty('topic')->getValue($thread),
            'created' => $object->getProperty('created')->getValue($thread)->format('Y-m-d H:i:s'),

            // In this use-case I don't need to search comments or do anything with that,
            // so it should be completely fine to just json them into one column
            'comments' => json_encode(
                $object->getProperty('comments')->getValue($thread)->getAll(),
                JSON_THROW_ON_ERROR
            ),
        ]);
    }
}
