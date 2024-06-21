<?php

namespace Tablelite\SupportPagination;

use Closure;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Tablelite\FeatureType;

trait SupportPagination
{
    protected ?Closure $paginateUsing = null;
    protected int $page = 1;

    private Htmlable $links;

    public function paginateUsing(Closure $paginateUsing)
    {
        $this->paginateUsing = $paginateUsing;
        return $this;
    }


    /**
     * @param  mixed  $records
     * @return Collection|mixed
     */
    public function handlePaginate(mixed $records): mixed
    {
        $this->getFeature()->add(FeatureType::PAGINATION);

        if ($records instanceof LengthAwarePaginator) {
            $this->links = $records->links('table-lite::pagination');
            return collect($records->items());
        }

        if (!$this->paginateUsing) {
            return $records;
        }

        $paginator = $this->evaluate($this->paginateUsing, [
            'records' => $records,
        ])->create();

        $this->links = $paginator->links('table-lite::pagination');
        return collect($paginator->items());
    }
}
