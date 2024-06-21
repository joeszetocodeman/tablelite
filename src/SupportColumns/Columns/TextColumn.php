<?php

namespace Tablelite\SupportColumns\Columns;

class TextColumn extends \Filament\Tables\Columns\TextColumn
{
    protected function getDefaultEvaluationParameters(): array
    {
        return [
            'record' => $this->getRecord()
        ];
    }
}
