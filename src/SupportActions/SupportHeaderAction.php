<?php

namespace Tablelite\SupportActions;


trait SupportHeaderAction
{
    protected array|\Closure $headerActions = [];

    public function headerActions(array|\Closure $actions): static
    {
        $this->headerActions = $actions;
        return $this;
    }

    public function getHeaderActions()
    {
        return $this->evaluate($this->headerActions, [
            'builder' => new ActionFactory($this)
        ]);
    }

}
