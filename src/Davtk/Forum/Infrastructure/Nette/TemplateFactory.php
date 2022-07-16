<?php

declare(strict_types=1);

namespace Davtk\Forum\Infrastructure\Nette;

use Nette\Application\UI\Control;
use Nette\Application\UI\Template;
use RuntimeException;

/**
 * nette\application requires to have any implementation of TemplateFactory.
 * In API, I do not need any template rendering so there is blank implementation just to satisfy the requirement.
 */
class TemplateFactory implements \Nette\Application\UI\TemplateFactory
{
    public function createTemplate(?Control $control = null): Template
    {
        throw new RuntimeException('I do not want to render templates');
    }
}
