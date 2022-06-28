<div class="sidebar sidebar-dark sidebar-fixed sidebar-self-hiding-xl" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <svg class="sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('img/brand/coreui.svg#full') }}"></use>
        </svg><!--sidebar-brand-full-->
        <svg class="sidebar-brand-narrow" width="46" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('img/brand/coreui.svg#signet') }}"></use>
        </svg><!--sidebar-brand-narrow-->
    </div><!--sidebar-brand-->

    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
        <li class="nav-item">
            <x-utils.link
                class="nav-link"
                :href="route('admin.dashboard')"
                :active="activeClass(Route::is('admin.dashboard'), 'active')"
                icon="nav-icon cil-speedometer"
                :text="__('Dashboard')" />
        </li><!--nav-item-->

        @if (
            $logged_in_user->hasAllAccess() ||
            (
                $logged_in_user->can('admin.access.user.list') ||
                $logged_in_user->can('admin.access.user.deactivate') ||
                $logged_in_user->can('admin.access.user.reactivate') ||
                $logged_in_user->can('admin.access.user.clear-session') ||
                $logged_in_user->can('admin.access.user.impersonate') ||
                $logged_in_user->can('admin.access.user.change-password')
            )
        )
            <li class="nav-title">@lang('System')</li><!--nav-title-->

            <li class="nav-group {{ activeClass(Route::is('admin.auth.user.*') || Route::is('admin.auth.role.*'), 'open show') }}">
                <x-utils.link
                    href="#"
                    icon="nav-icon cil-user"
                    class="nav-link nav-group-toggle"
                    :text="__('Access')" />

                <ul class="nav-group-items">
                    @if (
                        $logged_in_user->hasAllAccess() ||
                        (
                            $logged_in_user->can('admin.access.user.list') ||
                            $logged_in_user->can('admin.access.user.deactivate') ||
                            $logged_in_user->can('admin.access.user.reactivate') ||
                            $logged_in_user->can('admin.access.user.clear-session') ||
                            $logged_in_user->can('admin.access.user.impersonate') ||
                            $logged_in_user->can('admin.access.user.change-password')
                        )
                    )
                        <li class="nav-item">
                            <x-utils.link
                                :href="route('admin.auth.user.index')"
                                class="nav-link"
                                :text="__('User Management')"
                                :active="activeClass(Route::is('admin.auth.user.*'), 'active')" />
                        </li><!--nav-item-->
                    @endif

                    @if ($logged_in_user->hasAllAccess())
                        <li class="nav-item">
                            <x-utils.link
                                :href="route('admin.auth.role.index')"
                                class="nav-link"
                                :text="__('Role Management')"
                                :active="activeClass(Route::is('admin.auth.role.*'), 'active')" />
                        </li><!--nav-item-->
                    @endif
                </ul><!--nav-group-items-->
            </li><!--nav-group-->
        @endif

        @if ($logged_in_user->hasAllAccess())
            <li class="nav-group">
                <x-utils.link
                    href="#"
                    icon="nav-icon cil-list"
                    class="nav-link nav-group-toggle"
                    :text="__('Logs')" />

                <ul class="nav-group-items">
                    <li class="nav-item">
                        <x-utils.link
                            :href="route('log-viewer::dashboard')"
                            class="nav-link"
                            :text="__('Dashboard')" />
                    </li><!--nav-item-->
                    <li class="nav-item">
                        <x-utils.link
                            :href="route('log-viewer::logs.list')"
                            class="nav-link"
                            :text="__('Logs')" />
                    </li><!--nav-item-->
                </ul><!--nav-group-item-->
            </li><!--nav-group-->
        @endif
    </ul><!--sidebar-nav-->

    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button><!--sidebar-toggler-->
</div><!--sidebar-->
