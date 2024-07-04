<?php

namespace Tablelite;

use Closure;
use Filament\Support\Components\ViewComponent;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Component;
use Tablelite\SupportActions\SupportHeaderAction;
use Tablelite\SupportActions\SupportRowAction;
use Tablelite\SupportColumns\SupportColumns;
use Tablelite\SupportSelectable\SupportSelectable;
use Tablelite\SupportPagination\SupportPagination;
use Tablelite\SupportSlideOver\WithSlideOver;

class Table extends ViewComponent
{
    use SupportHeaderAction,
        WithSlideOver,
        SupportRowAction,
        SupportPagination,
        SupportColumns,
        SupportSelectable;


    public string $view = 'table-lite::index';


    protected array|Closure $records;
    protected ?Collection $cachedRecords = null;


    protected Builder|Closure|null $query = null;
    protected Component $livewire;
    protected array|Closure $getTableAllIdsUsing;

    protected Feature $feature;
    private string|Closure $keyBy = 'id';

    public function getColumns(): array
    {
        return $this->evaluate($this->schema);
    }

    protected function model(): Model
    {
        return new class extends Model {
            protected $guarded = false;
        };
    }

    public function records(array|Closure $records): static
    {
        $this->records = $records;
        return $this;
    }

    /**
     * @throws \Exception
     */
    public function getRecords(): Collection
    {
        if ($this->cachedRecords) {
            return $this->cachedRecords;
        }

        // handle query
        if (isset($this->query)) {
            $this->records(
                function ($page) {
                    $query = (clone $this->getQuery());
                    $this->applySearching($query);
                    return $query->paginate(10, page: $page);
                }
            );
        }

        $this->assertRecords();
        // evaluate records
        $records = $this->evaluate($this->records, [
            'page' => $this->page,
            'query' => $this->query,
            'keyword' => $this->livewire->tableData['tableSearchQuery'] ?? ''
        ]);

        data_set($this->livewire, 'tableData.idsInPage', collect($records)->pluck('id')->toArray());
        data_set($this->livewire, 'tableData.tableAllIds', $this->getTableAllIds());

        $records = $this->handlePaginate($records);
        $records = collect($records);

        // handle records
        return $this->cachedRecords = $records->map(function (array|Arrayable|Model $data) {
            if ($data instanceof Model) {
                return $data;
            }
            $data = $data instanceof Arrayable ? $data->toArray() : $data;
            return $this->model()->fill($data);
        });
    }


    public function getLinks(): ?Htmlable
    {
        return $this->links ?? null;
    }

    public function page(int $tablePage): void
    {
        $this->page = $tablePage;
    }

    public function query(Builder|Closure $query): static
    {
        $this->query = $query;
        return $this;
    }

    public function livewire(Component $livewire): static
    {
        $this->livewire = $livewire;
        return $this;
    }

    public function getQuery()
    {
        return $this->evaluate($this->query, [
            'keyword' => $this->livewire->tableData['tableSearchQuery'] ?? '',
        ]);
    }

    public function getSearchable(): bool|Closure
    {
        foreach ($this->getColumns() as $column) {
            if ($column->isSearchable()) {
                return true;
            }
        }
        return false;
    }

    protected function applySearching(Builder $query): Builder
    {
        $keyword = $this->livewire->tableData['tableSearchQuery'] ?? '';

        if (!$keyword) {
            return $query;
        }

        $query->where(function (Builder $query) use ($keyword) {
            $isFirst = true;

            foreach ($this->schema as $column) {
                $column->applySearchConstraint(
                    $query,
                    $keyword,
                    $isFirst,
                );
            }
        });

        return $query;
    }

    /**
     * @throws \Exception
     */
    private function getTableAllIds()
    {
        if ($this->getTableAllIdsUsing ?? false) {
            return $this->evaluate($this->getTableAllIdsUsing);
        }
        if (!$this->query) {
            $this->getFeature()->remove(FeatureType::BULK_SELECT);
            return null;
        }

        return $this->getQuery()->pluck('id')->toArray();
    }

    public function getTableAllIdsUsing(array|Closure $getTableAllIdsUsing): Table
    {
        $this->getTableAllIdsUsing = $getTableAllIdsUsing;
        return $this;
    }

    public function getFeature()
    {
        return $this->feature ??= new Feature();
    }

    public function hasFeature(string|FeatureType $feature): bool
    {
        if ($feature === FeatureType::BULK_SELECT->value) {
            return $this->getSelectable();
        }
        return $this->getFeature()->has($feature);
    }

    /**
     * @throws \Exception
     */
    private function assertRecords()
    {
        if (!isset($this->records)) {
            throw new \Exception('Please call records or query function');
        }
    }

    public function keyBy($keyBy)
    {
        $this->keyBy = $keyBy;
        return $this;
    }

    public function getKeyBy()
    {
        return $this->evaluate($this->keyBy);
    }
}
