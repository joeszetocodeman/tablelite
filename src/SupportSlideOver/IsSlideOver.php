<?php

namespace Tablelite\SupportSlideOver;

use Filament\Forms\Components\Placeholder;
use Filament\Support\Concerns\EvaluatesClosures;

trait IsSlideOver
{
    use EvaluatesClosures;

    public $actionKey = null;

    public function getSlideOverEventProperty()
    {
        return 'table-lite:show-slide-over-'.$this->actionKey;
    }

    protected function getListeners()
    {
        return [
            $this->slideOverEvent => 'onSlideOpen'
        ];
    }

    public function onSlideOpen()
    {

    }


    protected function onSlideOver(
        string $method = '',
        bool|\Closure $loading = false,
        string|\Closure|null $loadingPattern = 'aaaa|bbcc'
    ) {
        $event = $this->slideOverEvent;
        $pattern = $this->evaluate($loadingPattern);
        $loading = $this->evaluate($loading);
        return Placeholder::make($method)->view(
            'table-lite::on-slide-over-placeholder',
            compact('event', 'method', 'pattern', 'loading')
        )->label('');
    }

}
