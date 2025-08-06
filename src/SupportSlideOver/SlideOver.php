<?php

namespace Tablelite\SupportSlideOver;

use Filament\Support\Concerns\EvaluatesClosures;
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
        $params = array_merge($this->evaluate($this->params, [
            'record' => $this->action->getRecord(),
        ]), [
            'actionKey' => $this->action->getKey()
        ]);

        // Convert any UUID objects to strings for Livewire compatibility
        return $this->serializeUuids($params);
    }

    protected function serializeUuids($data)
    {
        if (is_array($data)) {
            return array_map([$this, 'serializeUuids'], $data);
        }

        // Check if it's a UUID object and convert to string
        if (is_object($data) && (
            $data instanceof \Ramsey\Uuid\UuidInterface ||
            $data instanceof \Ramsey\Uuid\Lazy\LazyUuidFromString
        )) {
            return (string) $data;
        }

        return $data;
    }
}
