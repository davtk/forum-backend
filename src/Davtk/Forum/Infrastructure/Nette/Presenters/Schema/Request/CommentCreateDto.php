<?php

declare(strict_types=1);

namespace Davtk\Forum\Infrastructure\Nette\Presenters\Schema\Request;

use Nette\Schema\Expect;
use Nette\Schema\Processor;
use Nette\Schema\ValidationException;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'Comment_Create')]
class CommentCreateDto
{
    // Properties are not in constructor because Nette\Schema does not support
    // castTo class which is using constructor property promotion
    // (yes, I have waiting pull request for this :D https://github.com/nette/schema/pull/47)

    #[OA\Property] public string $nickname;
    #[OA\Property] public string $email;
    #[OA\Property] public string $message;

    /** @throws ValidationException */
    public static function fromArray(array $data): self
    {
        return (new Processor())->process(
            Expect::structure([
                'nickname' => Expect::string()->required(),
                'email' => Expect::string()->required(),
                'message' => Expect::string()->required(),
            ])->castTo(self::class),
            $data
        );
    }
}
