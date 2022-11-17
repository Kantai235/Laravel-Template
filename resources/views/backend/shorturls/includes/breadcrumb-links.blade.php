<li class="nav-item">
    <x-utils.link
        class="nav-link"
        :href="route('admin.shorturls.deactivated')"
        :text="__('Deactivated Short Urls')"
        permission="admin.shorturls.reactivate" />
</li>
