<?php

namespace Tablelite\SupportColumns;


use Tablelite\SupportColumns\Columns\TextColumn;

class ColumnBuilder
{

    public function __construct()
    {
    }

    public function text($name)
    {
        return TextColumn::make($name);
    }
}
