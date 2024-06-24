<?php

namespace Tablelite\SupportSlideOver;

use Filament\Forms\Components\Placeholder;
use Illuminate\Support\HtmlString;

trait IsSlideOver
{
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


    protected function onSlideOver(string $method = '')
    {
        $event = $this->slideOverEvent;
        return Placeholder::make($method)->content(new HtmlString(<<<html
        <div x-on:$event.window="() => \$wire.call('$method')"></div>
        html
        ))->label('');
    }

}
