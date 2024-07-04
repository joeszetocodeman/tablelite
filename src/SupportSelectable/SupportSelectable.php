<?php

namespace Tablelite\SupportSelectable;

use Closure;

trait SupportSelectable
{
    protected bool|Closure $selectable = true;
    private ?Closure $selectableRecord = null;

    public function selectable(bool|Closure $selectable = true): static
    {
        $this->selectable = $selectable;
        return $this;
    }

    public function getSelectable()
    {
        return $this->evaluate($this->selectable);
    }


    public function selectableRecord(Closure $callback)
    {
        $this->selectableRecord = $callback;
        return $this;
    }

    public function getSelectableRecord($record)
    {
        if ( is_null($this->selectableRecord) ) {
            return true;
        }
        return $this->evaluate($this->selectableRecord, [
            'record' => $record
        ]);
    }
}
