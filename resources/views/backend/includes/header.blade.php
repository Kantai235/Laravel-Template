<header class="header header-sticky mb-4">
    <div class="container-fluid">
        <button class="header-toggler px-md-0 me-md-3" type="button" onclick="Coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <i class="icon icon-lg cil-menu"></i>
        </button><!--header-toggler-->

        <a class="header-brand d-md-none" href="#">
            <svg width="118" height="46" alt="CoreUI Logo">
                <use xlink:href="{{ asset('img/brand/coreui.svg#full') }}"></use>
            </svg>
        </a><!--header-brand-->

        <ul class="header-nav d-none d-md-flex">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('frontend.index') }}">@lang('Home')</a>
            </li><!--nav-item-->

            @if (config('template.locale.status') && count(config('template.locale.languages')) > 1)
                <li class="nav-item dropdown">
                    <x-utils.link :text="__(getLocaleName(app()->getLocale()))" class="nav-link dropdown-toggle" id="navbarDropdownLanguageLink" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false" />

                    @include('includes.partials.lang')
                </li><!--nav-item-->
            @endif
        </ul><!--header-nav-->

        <ul class="header-nav ms-auto">
            <li class="nav-item dropdown">
                <x-utils.link class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button"
                    aria-haspopup="true" aria-expanded="false">
                    <x-slot name="text">
                        <div class="avatar avatar-md">
                            <img class="avatar-img" src="{{ $logged_in_user->avatar }}" alt="{{ $logged_in_user->email ?? '' }}" />
                        </div><!--avatar-->
                    </x-slot><!--text-->
                </x-utils.link><!--nav-link-->

                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-light py-2">
                        <strong>@lang('Account')</strong>
                    </div><!--dropdown-header-->

                    <x-utils.link class="dropdown-item" icon="icon mr-2 cil-account-logout"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <x-slot name="text">
                            @lang('Logout')
                            <x-forms.post :action="route('frontend.auth.logout')" id="logout-form" class="d-none" />
                        </x-slot><!--text-->
                    </x-utils.link><!--dropdown-item-->
                </div><!--dropdown-menu-->
            </li><!--nav-item-->
        </ul><!--header-nav-->
    </div><!--container-fluid-->

    <div class="header-divider"></div><!--header-divider-->

    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            @include('backend.includes.partials.breadcrumbs')
        </nav><!--breadcrumb-->

        <ul class="header-nav ms-auto">
            @yield('breadcrumb-links')
        </ul><!--header-nav-->
    </div><!--container-fluid-->
</header><!--header-->
