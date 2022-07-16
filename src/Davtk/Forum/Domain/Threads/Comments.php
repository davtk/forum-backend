<?php

declare(strict_types=1);

namespace Davtk\Forum\Domain\Threads;

use JsonSerializable;

final class Comments implements JsonSerializable
{
    /** @param Comment[] $comments */
    public function __construct(
        private readonly array $comments = [],
    ) {
    }

    /** @throws CommentAlreadyExists */
    public function add(Comment $comment): self
    {
        try {
            $this->byUuid($comment->uuid());
            throw new CommentAlreadyExists();
        } catch (CommentNotExists) {
            $comments = $this->comments;
            $comments[] = $comment;

            return new self($comments);
        }
    }

    public function remove(string $uuid): self
    {
        $comments = array_filter(
            array: $this->comments,
            callback: static fn (Comment $comment) => $comment->uuid() !== $uuid,
        );

        return new self($comments);
    }

    /** @return Comment[] */
    public function getAll(): array
    {
        return array_values($this->comments);
    }

    /** @throws CommentNotExists */
    public function byUuid(string $uuid): Comment
    {
        foreach ($this->comments as $comment) {
            if ($comment->uuid() === $uuid) {
                return $comment;
            }
        }

        throw new CommentNotExists();
    }

    public function jsonSerialize(): array
    {
        return $this->comments;
    }
}
