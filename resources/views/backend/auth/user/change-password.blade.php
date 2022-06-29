@extends('backend.layouts.app')

@section('title', __('Change Password for :name', ['name' => $user->name]))

@section('content')
    <x-forms.patch :action="route('admin.auth.user.change-password.update', $user)">
        <x-backend.card>
            <x-slot name="header">
                @lang('Change Password for :name', ['name' => $user->name])
            </x-slot>

            <x-slot name="headerActions">
                <li class="nav-item">
                    <x-utils.link class="nav-link" :href="route('admin.auth.user.index')" :text="__('Cancel')" />
                </li><!--nav-item-->
            </x-slot>

            <x-slot name="body">
                <div class="form-floating mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password') }}" maxlength="100" required autocomplete="new-password" />

                    <label for="password">@lang('Password')</label>
                </div><!--form-floating-->

                <div class="form-floating mb-3">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Password Confirmation') }}" maxlength="100" required autocomplete="new-password" />

                    <label for="password_confirmation">@lang('Password Confirmation')</label>
                </div><!--form-floating-->
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-lg btn-primary float-right" type="submit">@lang('Update')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.patch>
@endsection
