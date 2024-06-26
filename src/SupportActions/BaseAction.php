<?php

namespace Tablelite\SupportActions;


use Closure;
use Filament\Support\Actions\Concerns\HasLabel;
use Filament\Support\Actions\Concerns\HasName;
use Filament\Support\Components\ViewComponent;
use Tablelite\SupportSlideOver\SlideOver;
use Tablelite\Table;

class BaseAction extends ViewComponent
{
    use HasLabel, HasName;

    protected string $view = 'table-lite::action.action';
    private Closure $action;
    protected string $slideover;
    protected Table $table;
    protected string $key = '';
    protected $record;
    protected bool|Closure $disable = false;
    private string $component = 'filament-support::button';

    public static function make(string $name): static
    {
        return (new static())->name($name);
    }

    public function action(Closure $action): static
    {
        $this->action = $action;
        return $this;
    }

    public function getAction(): Closure
    {
        return $this->action;
    }

    public function slideOver(string|Closure $component, array|Closure $params = []): static
    {
        $this->table->slideOver($this, $component, $params);
        return $this;
    }

    public function table(Table $table)
    {
        $this->table = $table;
        return $this;
    }

    public function getSlideOver(): ?SlideOver
    {
        return $this->table->getSlideOver($this->getName());
    }

    /**
     * @throws \Exception
     */
    public function setKey($key)
    {
        if (!$key) {
            throw new \Exception('Key is required, make sure property not null in your record');
        }
        $this->key = $key;
        return $this;
    }

    public function getKey()
    {
        return $this->getName().$this->key;
    }

    public function record($record)
    {
        $this->record = $record;
        return $this;
    }

    public function getRecord()
    {
        return $this->record;
    }

    public function getComponent()
    {
        return $this->component;
    }

    public function text()
    {
        $this->component = 'table-lite::action.text';
        return $this;
    }

    public function getDisable(): bool
    {
        return $this->evaluate($this->disable);
    }

    public function disable(bool|Closure $disable = true): static
    {
        $this->disable = $disable;
        return $this;
    }
}
