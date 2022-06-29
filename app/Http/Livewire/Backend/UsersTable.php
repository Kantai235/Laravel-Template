<?php

namespace App\Http\Livewire\Backend;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

/**
 * Class UsersTable.
 */
class UsersTable extends DataTableComponent
{
    /**
     * @var string
     */
    protected $model = User::class;

    /**
     * @var
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
    }

    /**
     * @param  string  $status
     */
    public function mount($status = 'active'): void
    {
        $this->status = $status;
    }

    /**
     * @return Builder
     */
    public function builder(): Builder
    {
        $query = User::with('roles', 'twoFactorAuth')->withCount('twoFactorAuth');

        if ($this->status === 'deleted') {
            $query = $query->onlyTrashed();
        } elseif ($this->status === 'deactivated') {
            $query = $query->onlyDeactivated();
        } else {
            $query = $query->onlyActive();
        }

        return $query
            ->when(null, fn ($query, $name) => $query->where('users.name', 'like', '%' . $name . '%'))
            ->when(null, fn ($query, $email) => $query->where('users.email', 'like', '%' . $email . '%'));
    }

    /**
     * @return array
     */
    public function filters(): array
    {
        return [
            SelectFilter::make('User Type')
                ->options([
                    '' => 'Any',
                    User::TYPE_ADMIN => 'Administrators',
                    User::TYPE_USER => 'Users',
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->where('type', $value);
                }),
            SelectFilter::make('Active')
                ->setFilterPillTitle('User Status')
                ->setFilterPillValues([
                    '1' => 'Active',
                    '0' => 'Inactive',
                ])
                ->options([
                    '' => 'All',
                    '1' => 'Yes',
                    '0' => 'No',
                ])
                ->filter(function(Builder $builder, string $value) {
                    if ($value === '1') {
                        $builder->where('active', true);
                    } elseif ($value === '0') {
                        $builder->where('active', false);
                    }
                }),
        ];
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            ImageColumn::make(__('Avatar'))
                ->location(function($row) {
                    return asset($row->getAvatar());
                })
                ->attributes(function($row) {
                    return [
                        'class' => 'img-fluid rounded',
                        'style' => 'max-width: 32px; max-height: 32px;',
                    ];
                }),
            Column::make(__('Type'))
                ->sortable(),
            Column::make('Name')
                ->sortable()
                ->searchable(),
            Column::make('E-mail', 'email')
                ->sortable()
                ->searchable(),
            Column::make('Active')
                ->label(
                    fn($row, Column $column) => view('backend.auth.user.includes.status')->with('user', $row)
                ),
            Column::make('Verified')
                ->label(
                    fn($row, Column $column) => view('backend.auth.user.includes.verified')->with('user', $row)
                ),
            Column::make(__('2FA'))
                ->label(
                    fn($row, Column $column) => view('backend.auth.user.includes.2fa')->with('user', $row)
                ),
            Column::make(__('Roles'))
                ->label(
                    fn($row, Column $column) => $row->roles_label
                ),
            Column::make(__('Additional Permissions'))
                ->label(
                    fn($row, Column $column) => $row->permissions_label
                ),
            Column::make(__('Actions'))
                ->label(
                    fn($row, Column $column) => view('backend.auth.user.includes.actions')->with('user', $row)
                ),
        ];
    }
}
