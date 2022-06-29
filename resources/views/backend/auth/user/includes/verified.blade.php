@if ($user->isVerified())
    <span class="badge bg-success" data-toggle="tooltip" title="{{ timezone()->convertToLocal($user->email_verified_at) }}">@lang('Yes')</span>
@else
    <span class="badge bg-danger">@lang('No')</span>
@endif
