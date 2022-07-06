@if($announcement->isEnabled())
    <span class='badge bg-success {{ isset($block) && $block ? "w-100" : null }}'>@lang('Enabled')</span>
@else
    <span class='badge bg-danger {{ isset($block) && $block ? "w-100" : null }}'>@lang('Inenabled')</span>
@endif
