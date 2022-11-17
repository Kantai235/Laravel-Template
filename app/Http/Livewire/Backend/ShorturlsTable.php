<?php

namespace App\Http\Livewire\Backend;

use App\Domains\ShortUrls\Models\ShortUrls;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

/**
 * Class ShorturlsTable.
 */
class ShorturlsTable extends DataTableComponent
{
    /**
     * @var string
     */
    protected $model = ShortUrls::class;

    /**
     * @var string
     */
    public $status;

    /**
     * You must implement the configure method on your component.
     * The only configuration method that is required is setPrimaryKey.
     * The primary key is a field on your model that acts as a unique identifier for the row. I.e. an ID, a UUID, etc.
     *
     * https://rappasoft.com/docs/laravel-livewire-tables/v2/usage/configuration
     *
     * @return void
     */
    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTableWrapperAttributes([
            'default' => false,
            'class' => 'table-responsive-xl',
        ]);
    }

    /**
     * @param  string  $status
     * @return void
     */
    public function mount($status = 'enabled'): void
    {
        $this->status = $status;
    }

    /**
     * @return Builder
     */
    public function builder(): Builder
    {
        $query = ShortUrls::select(
            'id',
            'user_id',
            'keyword',
            'url',
            'enabled',
            'password',
            'remark',
            'created_at',
            'updated_at'
        );

        if ($this->status === 'deleted') {
            $query = $query->onlyTrashed();
        } elseif ($this->status === 'deactivated') {
            $query = $query->where('enabled', false);
        } else {
            $query = $query->where('enabled', true);
        }

        return $query
            ->when(null, fn ($query, $keyword) => $query->where('shorturl.keyword', 'like', '%' . $keyword . '%'))
            ->when(null, fn ($query, $url) => $query->where('shorturl.url', 'like', '%' . $url . '%'))
            ->when(null, fn ($query, $remark) => $query->where('shorturl.remark', 'like', '%' . $remark . '%'));
    }

    /**
     * @return array<int, mixed>
     */
    public function filters(): array
    {
        return [
            SelectFilter::make('Enabled')
                ->setFilterPillTitle('Enabled Status')
                ->setFilterPillValues([
                    '1' => 'Enabled',
                    '0' => 'Inenabled',
                ])
                ->options([
                    '' => 'All',
                    '1' => 'Yes',
                    '0' => 'No',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value === '1') {
                        $builder->where('enabled', true);
                    } elseif ($value === '0') {
                        $builder->where('enabled', false);
                    }
                }),
            SelectFilter::make('Password')
                ->setFilterPillTitle('Password Status')
                ->setFilterPillValues([
                    '1' => 'Using',
                    '0' => 'Unused',
                ])
                ->options([
                    '' => 'All',
                    '1' => 'Yes',
                    '0' => 'No',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value === '1') {
                        $builder->whereNotNull('password');
                    } elseif ($value === '0') {
                        $builder->whereNull('password');
                    }
                }),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    public function columns(): array
    {
        return [
            Column::make(__('ID'), 'id')
                ->sortable()
                ->searchable(),
            Column::make(__('Short Url'), 'keyword')
                ->sortable()
                ->format(
                    fn ($value, $row, Column $column) => sprintf(
                        'From: <b>%s</b><br />To: <b>%s</b>',
                        route('frontend.shorturls.index', $row),
                        $row->url,
                    )
                )
                ->html(),
            // Column::make(__('Actions'))
            //     ->label(
            //         fn ($row, Column $column) => view('backend.announcement.includes.actions')
            //             ->with('announcement', $row)
            //     ),
        ];
    }
}
