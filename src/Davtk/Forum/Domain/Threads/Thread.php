<?php

declare(strict_types=1);

namespace Davtk\Forum\Domain\Threads;

use DateTimeImmutable;

final class Thread
{
    private Comments $comments;

    public function __construct(
        private string $uuid,
        private string $topic,
        private DateTimeImmutable $created,
    ) {
        $this->comments = new Comments();
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    /** @throws CommentAlreadyExists */
    public function addComment(Comment $comment): void
    {
        $this->comments = $this->comments->add($comment);
    }

    public function toDetail(
        AvatarProvider $avatarLinkProvider,
    ): ThreadDetail {
        return new ThreadDetail(
            uuid: $this->uuid,
            topic: $this->topic,
            created: $this->created,
            comments: array_map(
                callback: static fn (Comment $comment) => $comment->toDetail($avatarLinkProvider),
                array: $this->comments->getAll()
            ),
        );
    }
}
