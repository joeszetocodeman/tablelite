<?php

namespace Tablelite\SupportSlideOver;

use Closure;
use Tablelite\SupportActions\BaseAction;

trait WithSlideOver
{
    public array $slideOvers = [];

    public function slideOver(
        BaseAction $action,
        string|Closure $component,
        array|Closure $params = [],
    ): static {
        $this->slideOvers[$action->getKey()] = (new SlideOver($action, $component, $params));
        return $this;
    }

    public function getSlideOvers(): array
    {
        return $this->slideOvers;
    }

    public function getSlideOver(string $name): ?SlideOver
    {
        return $this->slideOvers[$name] ?? null;
    }
}
