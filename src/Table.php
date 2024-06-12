<?php

namespace Tablelite;

use Closure;
use Filament\Support\Components\ViewComponent;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class Table extends ViewComponent
{
    public string $view = 'table-lite::index';

    protected array $schema;

    protected array|Closure $records;
    protected ?Collection $cachedRecords = null;

    protected bool|Closure $selectable = true;

    private Htmlable $links;
    protected int $page = 1;
    protected Builder|Closure|null $query = null;
    protected Component $livewire;

    public function getColumns(): array
    {
        return $this->schema;
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

        // evaluate records
        $records = $this->evaluate($this->records, [
            'page' => $this->page,
            'query' => $this->query,
            'keyword' => $this->livewire->tableData['tableSearchQuery'] ?? '',
        ]);

        $this->livewire->tableData['idsInPage'] = $records->pluck('id')->toArray();
        $this->livewire->tableData['tableAllIds'] = $this->getQuery()->pluck('id')->toArray();

        // handle pagination
        if ($records instanceof LengthAwarePaginator) {
            $this->links = $records->links('table-lite::pagination');
            $records = collect($records->items());
        }

        // handle records
        return $this->cachedRecords = $records->map(function (array|Arrayable|Model $data) {
            if ($data instanceof Model) {
                return $data;
            }
            $data = $data instanceof Arrayable ? $data->toArray() : $data;
            return $this->model()->fill($data);
        });
    }

    public function selectable(bool|Closure $selectable = true): static
    {
        $this->selectable = $selectable;
        return $this;
    }

    public function getSelectable()
    {
        return $this->evaluate($this->selectable);
    }

    public function schema(array $schema): static
    {
        $this->schema = $schema;
        return $this;
    }

    public function getLinks(): Htmlable
    {
        return $this->links;
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
        foreach ($this->schema as $column) {
            if ($column instanceof TextColumn && $column->isSearchable()) {
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
}
