@if ($user->hasTwoFactorEnabled())
    <span class="badge bg-success" data-coreui-toggle="tooltip" title="{{ timezone()->convertToLocal($user->twoFactorAuth->enabled_at) }}">@lang('Yes')</span>
@else
    <span class="badge bg-danger">@lang('No')</span>
@endif
