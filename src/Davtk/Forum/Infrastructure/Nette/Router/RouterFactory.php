<?php

declare(strict_types=1);

namespace Davtk\Forum\Infrastructure\Nette\Router;

use Nette;
use Nette\Application\Routers\RouteList;

final class RouterFactory
{
    use Nette\StaticClass;

    public static function createRouter(): RouteList
    {
        $router = new RouteList();

        $router->addRoute('threads/<uuid>/comment', 'Thread:comment');
        $router->addRoute('threads/<uuid>', 'Thread:default');
        $router->addRoute('threads', 'Threads:default');

        $router->addRoute('<presenter>/<action>[/<id>]', 'Homepage:default');
        return $router;
    }
}
