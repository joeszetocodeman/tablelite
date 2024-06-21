<?php

namespace Tablelite;

use Illuminate\Pagination\LengthAwarePaginator;

class PaginatorBuilder
{

    protected $items;
    protected $total;
    protected $perPage;
    protected $currentPage;

    public function create()
    {
        return (new LengthAwarePaginator(
            items: $this->items,
            total: $this->total,
            perPage: $this->perPage,
            currentPage: $this->currentPage,
            options: [],
        ));
    }

    public function items($value)
    {
        $this->items = $value;
        return $this;
    }

    public function total($value)
    {
        $this->total = $value;
        return $this;
    }

    public function perPage($value)
    {
        $this->perPage = $value;
        return $this;
    }

    public function currentPage($value)
    {
        $this->currentPage = $value;
        return $this;
    }


}
