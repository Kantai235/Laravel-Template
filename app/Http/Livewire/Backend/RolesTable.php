<?php

namespace App\Http\Livewire\Backend;

use App\Domains\Auth\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

/**
 * Class RolesTable.
 */
class RolesTable extends DataTableComponent
{
    /**
     * @var string
     */
    protected $model = Role::class;

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
     * @return Builder
     */
    public function builder(): Builder
    {
        return Role::with('permissions:id,name,description')
            ->withCount('users')
            ->when(null, fn ($query, $term) => $query->search($term));
    }

    /**
     * @return array<int, mixed>
     */
    public function columns(): array
    {
        return [
            Column::make(__('Type'))
                ->sortable()
                ->label(
                    fn($row, Column $column) => view('backend.auth.role.includes.type')->with('model', $row)
                ),
            Column::make('Name')
                ->sortable()
                ->searchable(),
            Column::make(__('Permissions'))
                ->label(
                    fn($row, Column $column) => $row->permissions_label
                ),
            Column::make(__('Number of Users'), 'users_count')
                ->sortable()
                ->label(
                    fn($row, Column $column) => $row->users_count
                ),
            Column::make(__('Actions'))
                ->label(
                    fn($row, Column $column) => view('backend.auth.role.includes.actions')->with('model', $row)
                ),
        ];
    }
}
