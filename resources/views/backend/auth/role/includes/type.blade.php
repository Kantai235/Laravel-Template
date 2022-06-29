@if ($model->type === \App\Domains\Auth\Models\User::TYPE_ADMIN)
    {{ __('Administrator') }}
@elseif ($model->type === \App\Domains\Auth\Models\User::TYPE_USER)
    {{ __('User') }}
@else
    N/A
@endif
