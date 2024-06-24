<?php

namespace Tablelite\SupportSlideOver;

use Filament\Forms\Components\Placeholder;
use Filament\Support\Concerns\EvaluatesClosures;
use Illuminate\Support\HtmlString;

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


    protected function onSlideOver(string $method = '', bool|\Closure $loading = false)
    {
        $event = $this->slideOverEvent;
        $loadingEl = $this->evaluate($loading) ? '<div x-show="loading">loading...</div>' : '';
        return Placeholder::make($method)->content(new HtmlString(<<<html
        <div x-data="{ loading: false }"
        x-on:$event.window="async() => {
          loading = true
          await \$wire.call('$method')
          loading = false
        }"
        >
          $loadingEl
        </div>
        html
        ))->label('');
    }

}
