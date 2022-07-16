<?php

declare(strict_types=1);

namespace Davtk\Forum\Application;

use Davtk\Forum\Domain\DateTimeProvider;
use Davtk\Forum\Domain\Threads\AvatarProvider;
use Davtk\Forum\Domain\Threads\Comment;
use Davtk\Forum\Domain\Threads\CommentAlreadyExists;
use Davtk\Forum\Domain\Threads\Thread;
use Davtk\Forum\Domain\Threads\ThreadDetail;
use Davtk\Forum\Domain\Threads\ThreadNotExists;
use Davtk\Forum\Domain\Threads\ThreadRepository;
use Davtk\Forum\Domain\UuidProvider;

class ForumFacade
{
    public function __construct(
        private readonly UuidProvider $uuidProvider,
        private readonly DateTimeProvider $dateTimeProvider,
        private readonly ThreadRepository $threadRepository,
        private readonly AvatarProvider $avatarLinkProvider,
    ) {
    }

    public function create(
        string $topic,
        string $nickname,
        string $email,
        string $message,
    ): string {
        $thread = new Thread(
            uuid: $this->uuidProvider->provide(),
            topic: $topic,
            created: $this->dateTimeProvider->provide(),
        );

        try {
            $thread->addComment(
                new Comment(
                    uuid: $this->uuidProvider->provide(),
                    nickname: $nickname,
                    email: $email,
                    message: $message,
                    posted: $this->dateTimeProvider->provide(),
                )
            );
        } catch (CommentAlreadyExists) {
        }

        $this->threadRepository->persist($thread);

        return $thread->uuid();
    }

    /** @return array<ThreadDetail> */
    public function overview(): array
    {
        return array_map(
            callback: fn (Thread $thread) => $thread->toDetail(
                $this->avatarLinkProvider,
            ),
            array: $this->threadRepository->getAll(),
        );
    }

    /** @throws ThreadNotExists */
    public function detail(string $uuid): ThreadDetail
    {
        return $this->threadRepository->get($uuid)->toDetail(
            $this->avatarLinkProvider,
        );
    }

    /**
     * @throws ThreadNotExists
     * @throws CommentAlreadyExists
     */
    public function addComment(
        string $threadUuid,
        string $nickname,
        string $email,
        string $message
    ): void {
        $thread = $this->threadRepository->get($threadUuid);

        $thread->addComment(
            new Comment(
                uuid: $this->uuidProvider->provide(),
                nickname: $nickname,
                email: $email,
                message: $message,
                posted: $this->dateTimeProvider->provide(),
            )
        );

        $this->threadRepository->persist($thread);
    }
}
