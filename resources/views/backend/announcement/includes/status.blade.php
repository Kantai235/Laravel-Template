@if($announcement->isEnabled())
    <span class='badge bg-success w-100'>@lang('Enabled')</span>
@else
    <span class='badge bg-danger w-100'>@lang('Inenabled')</span>
@endif
