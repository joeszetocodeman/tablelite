<?php

namespace Tablelite\SupportColumns;


use Closure;
use Filament\Support\Concerns\EvaluatesClosures;

trait SupportColumns
{
    use EvaluatesClosures;

    protected array|Closure $schema;

    public function schema(array|Closure $schema): static
    {
        $this->schema = $schema;
        return $this;
    }

    public function getColumns(): array
    {
        return $this->evaluate($this->schema, [
            'column' => new ColumnBuilder
        ]);
    }
}
