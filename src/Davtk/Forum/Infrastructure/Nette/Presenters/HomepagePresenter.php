<?php

declare(strict_types=1);

namespace Davtk\Forum\Infrastructure\Nette\Presenters;

use Davtk\Forum\Infrastructure\Nette\Presenters\Schema\Response\StatusDto;
use OpenApi\Attributes as OA;

final class HomepagePresenter extends BaseApiPresenter
{
    public function getDefault(): never
    {
        $this->sendJson(
            new StatusDto(StatusDto::STATUS_OK, 'alive'),
        );
    }
}
