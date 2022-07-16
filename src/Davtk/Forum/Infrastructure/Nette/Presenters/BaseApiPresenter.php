<?php

declare(strict_types=1);

namespace Davtk\Forum\Infrastructure\Nette\Presenters;

use JsonException;
use Nette\Application\UI\Presenter;
use Nette\Schema\ValidationException;

abstract class BaseApiPresenter extends Presenter
{
    public static function formatActionMethod(string $action): string
    {
        // Yeah, I know that accessing SERVER directly is not good, but in this static function I don't have access
        // to ->getHttpRequest so there is probably no nice & easy way how get the HTTP method

        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $action = ucfirst(strtolower($action));

        return $method . $action;
    }

    public function startup(): void
    {
        parent::startup();

        $this->getHttpResponse()->setHeader('Access-Control-Allow-Origin', '*');
        $this->getHttpResponse()->setHeader('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS');
        $this->getHttpResponse()->setHeader('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token');
    }

    public function beforeRender(): void
    {
        $this->sendJson([
            'status' => 'error',
            'data' => 'Template rendering is not allowed',
        ]);
    }

    /** @throws ValidationException */
    public function getJson(): array|null
    {
        try {
            return json_decode(
                file_get_contents('php://input'),
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException) {
            throw new ValidationException('Invalid JSON schema');
        }
    }
}
