<?php

declare(strict_types=1);

namespace Davtk\Forum\Infrastructure\Nette\Presenters;

use Davtk\Forum\Application\ForumFacade;
use Davtk\Forum\Domain\Threads\ThreadDetail;
use Davtk\Forum\Domain\Threads\ThreadNotExists;
use Davtk\Forum\Infrastructure\Nette\Presenters\Schema\Request\ThreadCreateDto;
use Davtk\Forum\Infrastructure\Nette\Presenters\Schema\Response\StatusDto;
use Davtk\Forum\Infrastructure\Nette\Presenters\Schema\Response\ThreadDetailDto;
use Nette\Schema\ValidationException;
use OpenApi\Attributes as OA;

class ThreadsPresenter extends BaseApiPresenter
{
    public function __construct(
        private readonly ForumFacade $forum,
    ) {
        parent::__construct();
    }


    #[OA\Get(
        path: '/threads',
        operationId: 'getThreads',
        tags: ['threads'],
    )]
    #[OA\Response(
        response: 200,
        description: 'List of threads',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                ref: '#/components/schemas/Thread_Detail',
            ),
        ),
    )]
    public function getDefault(): never
    {
        $threads = array_map(
            callback: static fn (ThreadDetail $threadDetail) => ThreadDetailDto::fromObject($threadDetail),
            array: $this->forum->overview(),
        );

        $this->sendJson(
            $threads,
        );
    }

    #[OA\Post(
        path: '/threads',
        operationId: 'createThread',
        tags: ['threads'],
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: '#/components/schemas/Thread_Create',
        ),
    )]
    #[OA\Response(
        response: 200,
        description: 'Created thread',
        content: new OA\JsonContent(
            ref: '#/components/schemas/Thread_Detail',
        ),
    )]
    public function postDefault(): never
    {
        try {
            $request = ThreadCreateDto::fromArray(
                $this->getJson(),
            );

            $uuid = $this->forum->create(
                topic: $request->topic,
                nickname: $request->nickname,
                email: $request->email,
                message: $request->message,
            );

            $this->sendJson(
                ThreadDetailDto::fromObject($this->forum->detail($uuid))
            );
        } catch (ValidationException $e) {
            $this->getHttpResponse()->setCode(400);
            $this->sendJson(new StatusDto(StatusDto::STATUS_ERROR, $e->getMessage()));
        } catch (ThreadNotExists) {
            $this->getHttpResponse()->setCode(404);
            $this->sendJson(StatusDto::notFound());
        }
    }
}
