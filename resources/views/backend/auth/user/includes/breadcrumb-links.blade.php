<li class="nav-item">
    <x-utils.link
        class="nav-link"
        :href="route('admin.auth.user.deactivated')"
        :text="__('Deactivated Users')"
        permission="admin.access.user.reactivate" />
</li>

@if ($logged_in_user->hasAllAccess())
    <li class="nav-item">
        <x-utils.link
            class="nav-link"
            :href="route('admin.auth.user.deleted')"
            :text="__('Deleted Users')" />
    </li>
@endif
