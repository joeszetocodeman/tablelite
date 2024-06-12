<?php

namespace Tablelite;

trait InteractsWithTablelite
{
    protected Table $table;

    public array $tableData = [
        'tablePage' => 1,
        'selectedRecords' => [],
        'idsInPage' => [],
        'tableAllIds' => [],
        'tableSearchQuery' => '',
    ];

    public function bootMyInteractsWithTable(): void
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

    public function getTable(): Table
    {
        $this->table->page(data_get($this->tableData, 'tablePage'));
        return $this->table;
    }


}
