<?php

namespace Tablelite\SupportActions;


use Tablelite\Table;

class ActionFactory
{
    public function __construct(protected Table $table)
    {
    }

    public function make(string $key): Action
    {
        return Action::make($key)->table($this->table);
    }

    public function detail(string $key): Action
    {
        return DetailAction::make($key)->table($this->table);
    }
}
