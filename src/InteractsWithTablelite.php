<?php

namespace Tablelite;

use Tablelite\SupportActions\BaseAction;

trait InteractsWithTablelite
{
    use \Tablelite\livewire\WithAction;

    protected Table $table;

    public array $tableData = [
        'tablePage' => 1,
        'selectedRecords' => [],
        'idsInPage' => [],
        'tableAllIds' => [],
        'tableSearchQuery' => '',
        'sort' => []
    ];

    public function bootInteractsWithTablelite(): void
    {
        $this->table = new Table();
        $this->table->livewire($this);
        $this->table($this->table);
    }

    public function gotoPage($page): void
    {
        if ($page == 'next') {
            $this->tableData['tablePage']++;
            return;
        }

        if ($page == 'prev') {
            $this->tableData['tablePage']--;
            return;
        }

        $this->tableData['tablePage'] = $page;
    }


    public function callTableAction($actionName, $id)
    {
        $record = collect($this->table->getRecords())->where('id', $id)->first();
        $action = collect($this->table->getActions())->firstWhere(
            fn(BaseAction $action) => $action->getName() === $actionName
        );
        $this->evaluate($action->record($record)->getAction(), ['record' => $record]);
    }

    public function getTable(): Table
    {
        $this->table
            ->page(data_get($this->tableData, 'tablePage') );
        return $this->table;
    }

    public function sortTable($name)
    {
        $this->tableData['sort'] = [
            $name => ($this->tableData['sort'][$name] ?? '') === 'asc' ? 'desc' : 'asc'
        ];
    }

    public function updatedTableDataTableSearchQuery()
    {
        $this->tableData['tablePage'] = 1;
    }
}
