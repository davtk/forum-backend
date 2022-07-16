<?php

declare(strict_types=1);

namespace Davtk\Forum\Infrastructure\Nette\Presenters;

use Davtk\Forum\Infrastructure\Nette\Presenters\Schema\Response\StatusDto;
use Nette;
use Nette\Application\Responses;
use Nette\Http;
use Throwable;
use Tracy\ILogger;

final class ErrorPresenter implements Nette\Application\IPresenter
{
    use Nette\SmartObject;

    public function __construct(
        private readonly ILogger $logger,
        private readonly Http\Response $response,
    ) {
    }

    public function run(Nette\Application\Request $request): Nette\Application\Response
    {
        $exception = $request->getParameter('exception');
        assert($exception instanceof Throwable);

        if ($exception instanceof Nette\Application\BadRequestException) {
            $this->response->setCode(Http\IResponse::S404_NOT_FOUND);
            return new Responses\JsonResponse(
                StatusDto::notFound()
            );
        }

        $this->logger->log($exception, ILogger::EXCEPTION);

        $this->response->setCode(Http\IResponse::S500_INTERNAL_SERVER_ERROR);
        return new Responses\JsonResponse(
            new StatusDto(
                StatusDto::STATUS_ERROR,
                $exception->getMessage(),
            ),
        );
    }
}
