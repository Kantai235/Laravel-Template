<?php

namespace App\Http\Livewire\Backend;

use App\Domains\Announcement\Models\Announcement;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

/**
 * Class AnnouncementTable.
 */
class AnnouncementTable extends DataTableComponent
{
    /**
     * @var string
     */
    protected $model = Announcement::class;

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
            'class' => 'table-responsive-xl'
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
        $query = Announcement::select('id', 'area', 'type', 'message', 'enabled', 'dismissable', 'starts_at', 'ends_at');

        if ($this->status === 'deleted') {
            $query = $query->onlyTrashed();
        } else if ($this->status === 'deactivated') {
            $query = $query->where('enabled', false);
        } else {
            $query = $query->where('enabled', true);
        }

        return $query
            ->when(null, fn ($query, $message) => $query->where('announcement.message', 'like', '%' . $message . '%'));
    }

    /**
     * @return array<int, mixed>
     */
    public function filters(): array
    {
        return [
            SelectFilter::make('Area')
                ->options([
                    '' => 'Any',
                    Announcement::AREA_BACKEND => 'Backend',
                    Announcement::AREA_FRONTEND => 'Frontend',
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->where('area', $value);
                }),
            SelectFilter::make('Type')
                ->options([
                    '' => 'Any',
                    Announcement::TYPE_PRIMARY => 'Primary',
                    Announcement::TYPE_SECONDARY => 'Secondary',
                    Announcement::TYPE_SUCCESS => 'Success',
                    Announcement::TYPE_DANGER => 'Danger',
                    Announcement::TYPE_WARNING => 'Warning',
                    Announcement::TYPE_INFO => 'Info',
                    Announcement::TYPE_LIGHT => 'Light',
                    Announcement::TYPE_DARK => 'Dark',
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->where('type', $value);
                }),
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
                ->filter(function(Builder $builder, string $value) {
                    if ($value === '1') {
                        $builder->where('enabled', true);
                    } elseif ($value === '0') {
                        $builder->where('enabled', false);
                    }
                }),
            SelectFilter::make('Dismissable')
                ->setFilterPillTitle('Dismissable Status')
                ->setFilterPillValues([
                    '1' => 'Dismissable',
                    '0' => 'Undismissable',
                ])
                ->options([
                    '' => 'All',
                    '1' => 'Yes',
                    '0' => 'No',
                ])
                ->filter(function(Builder $builder, string $value) {
                    if ($value === '1') {
                        $builder->where('dismissable', true);
                    } elseif ($value === '0') {
                        $builder->where('dismissable', false);
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
            Column::make(__('Message'), 'message')
                ->sortable()
                ->searchable()
                ->format(
                    fn($value, $row, Column $column) => '<div class="alert alert-' . $row->type . ' p-1 m-0" role="alert">' . $row->message . '</div>'
                )
                ->html(),
            Column::make(__('Area'), 'area')
                ->sortable()
                ->label(
                    fn($row, Column $column) => view('backend.announcement.includes.area')->with('announcement', $row)->with('block', true)
                ),
            Column::make(__('Type'), 'type')
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => '<span class="badge bg-' . $row->type . ' w-100">' . strtoupper($row->type) . '</span>'
                )
                ->html(),
            Column::make(__('Enabled Status'), 'enabled')
                ->label(
                    fn($row, Column $column) => view('backend.announcement.includes.status')->with('announcement', $row)->with('block', true)
                ),
            Column::make(__('Dismissable Status'), 'dismissable')
                ->label(
                    fn($row, Column $column) => view('backend.announcement.includes.dismissable')->with('announcement', $row)->with('block', true)
                ),
            Column::make(__('Starts At'), 'starts_at')
                ->sortable()
                ->label(
                    fn($row, Column $column) => view('backend.announcement.includes.starts')->with('announcement', $row)
                ),
            Column::make(__('Ends At'), 'ends_at')
                ->sortable()
                ->label(
                    fn($row, Column $column) => view('backend.announcement.includes.ends')->with('announcement', $row)
                ),
            Column::make(__('Actions'))
                ->label(
                    fn($row, Column $column) => view('backend.announcement.includes.actions')->with('announcement', $row)
                ),
        ];
    }
}
