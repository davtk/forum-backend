<?php

declare(strict_types=1);

namespace Davtk\Forum\Infrastructure\Nette\Presenters\Schema\Response;

use Davtk\Forum\Domain\Threads\CommentDetail;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'Comment_Detail')]
final class CommentDetailDto
{
    public function __construct(
        #[OA\Property] public readonly string $uuid,
        #[OA\Property] public readonly string $nickname,
        #[OA\Property] public readonly string $avatar_link,
        #[OA\Property] public readonly string $email,
        #[OA\Property] public readonly string $message,
        #[OA\Property] public readonly string $posted,
    ) {
    }

    public static function fromObject(CommentDetail $comment): self
    {
        return new self(
            uuid: $comment->uuid,
            nickname: $comment->nickname,
            avatar_link: $comment->avatar_link,
            email: $comment->email,
            message: $comment->message,
            posted: $comment->posted->format('Y-m-d H:i:s'),
        );
    }
}
