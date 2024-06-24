<?php

namespace Tablelite\SupportSlideOver;

trait IsSlideOver
{
    public $actionKey = null;

    protected function getListeners()
    {
        return [
            'table-lite:show-slide-over-'.$this->actionKey => 'onSlideOpen'
        ];
    }
}
