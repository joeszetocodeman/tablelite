<?php

namespace Tablelite\SupportSlideOver;

use App\Domain\CouponInsert\Traits\EvaluatesClosures;
use Closure;
use Tablelite\SupportActions\BaseAction;

class SlideOver
{
    use EvaluatesClosures;

    public function __construct(
        public BaseAction $action,
        public string|Closure $component,
        public array|Closure $params = []
    ) {
    }

    public function getKey()
    {
        return $this->action->getKey();
    }

    public function getComponent()
    {
        return $this->evaluate($this->component, [
            'record' => $this->action->getRecord(),
        ]);
    }

    public function getParams()
    {
        return array_merge($this->evaluate($this->params, [
            'record' => $this->action->getRecord(),
        ]), [
            'actionKey' => $this->action->getKey()
        ]);
    }
}
