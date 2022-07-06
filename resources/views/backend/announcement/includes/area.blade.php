@switch($announcement->area)
    @case('frontend')
        <span class='badge bg-warning {{ isset($block) && $block ? "w-100" : null }}'>@lang('Frontend')</span>
        @break

    @case('backend')
        <span class='badge bg-danger {{ isset($block) && $block ? "w-100" : null }}'>@lang('Backend')</span>
        @break

    @default
        <span class='badge bg-success {{ isset($block) && $block ? "w-100" : null }}'>@lang('Fullstack')</span>
        @break
@endswitch
