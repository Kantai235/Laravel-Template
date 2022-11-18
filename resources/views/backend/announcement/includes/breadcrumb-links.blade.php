<li class="nav-item">
    <x-utils.link
        class="nav-link"
        :href="route('admin.announcement.deactivated')"
        :text="__('Deactivated Announcements')"
        permission="admin.announcement.reactivate" />
</li>

<li class="nav-item">
    <x-utils.link
        class="nav-link"
        :href="route('admin.announcement.deleted')"
        :text="__('Deleted Announcements')"
        permission="admin.announcement.reactivate" />
</li>
