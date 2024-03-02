<?php

namespace App\Livewire\LivewireTables;

use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class HtmlLinkColumn extends LinkColumn
{
    protected string $view = 'livewire-tables.includes.columns.link';
}
