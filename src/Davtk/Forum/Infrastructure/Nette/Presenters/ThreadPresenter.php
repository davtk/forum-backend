<?php

declare(strict_types=1);

namespace Davtk\Forum\Infrastructure\Nette\Presenters;

use Davtk\Forum\Application\ForumFacade;
use Davtk\Forum\Domain\Threads\CommentAlreadyExists;
use Davtk\Forum\Domain\Threads\ThreadNotExists;
use Davtk\Forum\Infrastructure\Nette\Presenters\Schema\Request\CommentCreateDto;
use Davtk\Forum\Infrastructure\Nette\Presenters\Schema\Response\StatusDto;
use Davtk\Forum\Infrastructure\Nette\Presenters\Schema\Response\ThreadDetailDto;
use Nette\Schema\ValidationException;
use OpenApi\Attributes as OA;

class ThreadPresenter extends BaseApiPresenter
{
    public function __construct(
        private readonly ForumFacade $forum,
    ) {
        parent::__construct();
    }

    #[OA\Get(
        path: '/threads/{uuid}',
        operationId: 'getThread',
        summary: 'Get single thread',
        tags: ['threads'],
    )]
    #[OA\PathParameter(
        name: 'uuid',
        required: true,
        schema: new OA\Schema(type: 'string'),
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
    public function getDefault(string $uuid): never
    {
        try {
            $this->sendJson(
                ThreadDetailDto::fromObject($this->forum->detail($uuid))
            );
        } catch (ThreadNotExists) {
            $this->getHttpResponse()->setCode(404);
            $this->sendJson(StatusDto::notFound());
        }
    }

    #[OA\Post(
        path: '/threads/{uuid}',
        operationId: 'commentThread',
        summary: 'Comment on thread',
        tags: ['threads'],
    )]
    #[OA\PathParameter(
        name: 'uuid',
        required: true,
        schema: new OA\Schema(type: 'string'),
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: '#/components/schemas/Comment_Create',
        ),
    )]
    #[OA\Response(
        response: 200,
        description: 'Created thread',
        content: new OA\JsonContent(
            ref: '#/components/schemas/Thread_Detail',
        ),
    )]
    public function postDefault(string $uuid): never
    {
        try {
            $request = CommentCreateDto::fromArray(
                $this->getJson(),
            );

            $this->forum->addComment(
                $uuid,
                $request->nickname,
                $request->email,
                $request->message,
            );

            $this->sendJson(
                ThreadDetailDto::fromObject($this->forum->detail($uuid))
            );
        } catch (ValidationException $e) {
            $this->getHttpResponse()->setCode(400);
            $this->sendJson(new StatusDto(StatusDto::STATUS_ERROR, $e->getMessage()));
        } catch (CommentAlreadyExists) {
            $this->getHttpResponse()->setCode(500);
            $this->sendJson(StatusDto::internal());
        } catch (ThreadNotExists) {
            $this->getHttpResponse()->setCode(404);
            $this->sendJson(StatusDto::notFound());
        }

        $this->getHttpResponse()->setCode(500);
        $this->sendJson(StatusDto::unknown());
    }
}
