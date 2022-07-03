<ul class="dropdown-menu dropdown-menu-right overflow-auto" style="max-height: 200px;" aria-labelledby="navbarDropdownLanguageLink">
    @foreach(collect(config('template.locale.languages'))->sortBy('name') as $code => $details)
        @if($code !== app()->getLocale())
            <x-utils.link class="dropdown-item pt-1 pb-1" :href="route('locale.change', $code)" :text="__(getLocaleName($code))" />
        @endif
    @endforeach
</ul><!--dropdown-menu-->
