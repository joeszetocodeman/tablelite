<?php

namespace Tablelite\SupportSlideOver;

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
}
