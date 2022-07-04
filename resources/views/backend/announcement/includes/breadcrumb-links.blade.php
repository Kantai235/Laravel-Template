<li class="nav-item">
    <x-utils.link
        class="nav-link"
        :href="route('admin.announcement.deactivated')"
        :text="__('Deactivated Announcements')"
        permission="admin.announcement.reactivate" />
</li>
