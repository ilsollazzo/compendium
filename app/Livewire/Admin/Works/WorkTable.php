<?php

namespace App\Livewire\Admin\Works;

use App\Livewire\LivewireTables\HtmlLinkColumn;
use App\Models\Language;
use App\Models\Work;
use Illuminate\Database\Eloquent\Builder;
use Nette\Utils\Html;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class WorkTable extends DataTableComponent
{
    protected $model = Work::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        $current_language_id = Language::where('iso_639_1', '=', app()->getLocale())->first()->id;
        return [
            ImageColumn::make(__('validation.attributes.thumbnail'), 'id')
                ->location(fn($row) => route('works.thumbnail', $row->id))
                ->attributes(fn($row) => [
                    'style' => 'width: 150px;',
                ]),
            Column::make(__('validation.attributes.id'), 'id'),
            Column::make(__('validation.attributes.slug'), 'slug'),
            Column::make(__('validation.attributes.title'))
                ->label(fn(Work $record) => $record->titles->where('language_id', $current_language_id)->first()->title ?? $record->titles->pluck('title')->join(' / '))
                ->searchable(fn(Builder $work, string $searchTerm) => $work->whereHas('titles', fn(Builder $titles) => $titles->where('title', 'LIKE', "%$searchTerm%"))),
            Column::make(__('validation.attributes.year'), 'year')->sortable()->searchable(),
            Column::make(__('validation.attributes.length'), 'length'),
            Column::make(__('validation.attributes.type'), 'work_type.name')->format(fn($workType) => __("works.types.{$workType}")),
            Column::make(__('validation.attributes.lists'), 'id')
                ->label(fn(Work $record) => $record->work_lists->pluck('slug')->join(', ')),
            ButtonGroupColumn::make(__('common.actions'))
                ->buttons([
                    HtmlLinkColumn::make(__('common.edit'))
                        ->title(fn() => "<i><i class='fas fa-edit'></i>")
                        ->location(fn($row) => '#')
                        ->attributes(fn($row) => [
                            'class' => 'btn btn-primary',
                        ])->html(),
                ]),
        ];
    }
}
