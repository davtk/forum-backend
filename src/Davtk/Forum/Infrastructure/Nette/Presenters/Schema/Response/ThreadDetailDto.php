<?php

declare(strict_types=1);

namespace Davtk\Forum\Infrastructure\Nette\Presenters\Schema\Response;

use Davtk\Forum\Domain\Threads\CommentDetail;
use Davtk\Forum\Domain\Threads\ThreadDetail;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'Thread_Detail')]
final class ThreadDetailDto
{
    public function __construct(
        #[OA\Property] public readonly string $uuid,
        #[OA\Property] public readonly string $topic,
        #[OA\Property] public readonly string $created,
        #[OA\Property(
            items: new OA\Items(
                ref: '#/components/schemas/Comment_Detail',
            )
        )]
        public readonly array $comments,
    ) {
    }

    public static function fromObject(ThreadDetail $thread): self
    {
        return new self(
            uuid: $thread->uuid,
            topic: $thread->topic,
            created: $thread->created->format('Y-m-d H:i:s'),
            comments: array_map(
                callback: static fn (CommentDetail $commentDetail)
                    => CommentDetailDto::fromObject($commentDetail),
                array: $thread->comments,
            ),
        );
    }
}
