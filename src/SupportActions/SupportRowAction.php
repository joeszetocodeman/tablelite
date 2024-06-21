<?php

namespace Tablelite\SupportActions;


trait SupportRowAction
{
    protected array|\Closure $actions = [];

    public function actions(array|\Closure $actions): static
    {
        $this->actions = $actions;
        return $this;
    }

    public function getActions()
    {
        return $this->evaluate($this->actions, [
            'builder' => new \Tablelite\SupportActions\ActionFactory($this),
        ]);
    }

}
