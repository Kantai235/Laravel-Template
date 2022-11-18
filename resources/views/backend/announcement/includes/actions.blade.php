@if ($announcement->trashed() && ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.announcement.destore')))
    <x-utils.form-button
        :action="route('admin.announcement.restore', $announcement)"
        method="patch"
        button-class="btn btn-info btn-sm"
        icon="fas fa-sync-alt"
        name="confirm-item"
    >
        @lang('Restore')
    </x-utils.form-button>

    <x-utils.delete-button
        :href="route('admin.announcement.permanently-delete', $announcement)"
        :text="__('Permanently Delete')" />
@else
    @if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.announcement.list'))
        <x-utils.view-button :href="route('admin.announcement.show', $announcement)" />
        <x-utils.edit-button
            :href="route('admin.announcement.edit', $announcement)"
            permission="admin.announcement.edit" />
    @endif

    @if (!$announcement->isEnabled())
        <x-utils.form-button
            :action="route('admin.announcement.mark', [$announcement, 1])"
            method="patch"
            button-class="btn btn-primary btn-sm"
            icon="fas fa-sync-alt"
            name="confirm-item"
            permission="admin.announcement.deactivate"
        >
            @lang('Reactivate')
        </x-utils.form-button>
    @else
        <x-utils.form-button
            :action="route('admin.announcement.mark', [$announcement, 0])"
            method="patch"
            button-class="btn btn-warning btn-sm"
            icon="fa-solid fa-bell"
            name="confirm-item"
            permission="admin.announcement.deactivate"
        >
            @lang('Deactivate')
        </x-utils.form-button>
    @endif

    <x-utils.delete-button
        :href="route('admin.announcement.destroy', $announcement)"
        permission="admin.announcement.destore" />
@endif
