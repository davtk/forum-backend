<?php

declare(strict_types=1);

namespace Davtk\Forum\Domain\Threads;

use DateTimeImmutable;
use JsonSerializable;

final class Comment implements JsonSerializable
{
    public function __construct(
        private string $uuid,
        private string $nickname,
        private string $email,
        private string $message,
        private DateTimeImmutable $posted,
    ) {
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function toDetail(
        AvatarProvider $avatarLinkProvider,
    ): CommentDetail {
        return new CommentDetail(
            uuid: $this->uuid,
            nickname: $this->nickname,
            avatar_link: $avatarLinkProvider->getLink($this->email),
            email: $this->email,
            message: $this->message,
            posted: $this->posted,
        );
    }

    public function jsonSerialize(): object
    {
        return (object) [
            'uuid' => $this->uuid,
            'nickname' => $this->nickname,
            'email' => $this->email,
            'message' => $this->message,
            'posted' => $this->posted->format('Y-m-d H:i:s'),
        ];
    }
}
