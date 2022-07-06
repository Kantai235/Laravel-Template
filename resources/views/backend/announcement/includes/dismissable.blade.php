@if($announcement->isDismissable())
    <span class='badge bg-success {{ isset($block) && $block ? "w-100" : null }}'>@lang('Dismissable')</span>
@else
    <span class='badge bg-danger {{ isset($block) && $block ? 'w-100' : null }}'>@lang('Undismissable')</span>
@endif
