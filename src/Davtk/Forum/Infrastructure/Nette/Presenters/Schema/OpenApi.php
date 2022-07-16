<?php

declare(strict_types=1);

namespace Davtk\Forum\Infrastructure\Nette\Presenters\Schema;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "Davtk / Forum - Backend",
    contact: new OA\Contact(
        name: 'Daniel Vitek',
        url: 'https://www.linkedin.com/in/daniel-vitek/',
        email: 'kontakt@danielvitek.me',
    )
)]
#[OA\Server(
    url: 'http://localhost',
)]
class OpenApi
{

}
