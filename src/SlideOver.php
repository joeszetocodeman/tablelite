<?php

namespace Tablelite;

use App\Domain\CouponInsert\Traits\EvaluatesClosures;
use Closure;
use Tablelite\SupportActions\BaseAction;

class SlideOver
{
    use EvaluatesClosures;

    public function __construct(
        public BaseAction $action,
        public string $component,
        public array|Closure $params = []
    ) {
    }

    public function getKey()
    {
        return $this->action->getKey();
    }

    public function getParams()
    {
        return $this->evaluate($this->params, [
            'record' => $this->action->getRecord()
        ]);
    }
}
