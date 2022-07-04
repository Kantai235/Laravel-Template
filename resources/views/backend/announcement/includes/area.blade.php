@switch($announcement->area)
    @case('frontend')
        <span class='badge bg-warning'>@lang('Frontend')</span>
        @break

    @case('backend')
        <span class='badge bg-danger'>@lang('Backend')</span>
        @break

    @default
        <span class='badge bg-success'>@lang('Fullstack')</span>
        @break
@endswitch
