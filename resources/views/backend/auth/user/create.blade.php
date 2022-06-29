@inject('model', '\App\Domains\Auth\Models\User')

@extends('backend.layouts.app')

@section('title', __('Create User'))

@section('content')
    <x-forms.post :action="route('admin.auth.user.store')">
        <x-backend.card>
            <x-slot name="header">
                @lang('Create User')
            </x-slot>

            <x-slot name="headerActions">
                <li class="nav-item">
                    <x-utils.link class="nav-link" :href="route('admin.auth.user.index')" :text="__('Cancel')" />
                </li><!--nav-item-->
            </x-slot>

            <x-slot name="body">
                <div x-data="{userType : '{{ $model::TYPE_USER }}'}">
                    <div class="form-floating mb-3">
                        <select name="type" id="type" class="form-control" x-on:change="userType = $event.target.value">
                            <option value="{{ $model::TYPE_USER }}">@lang('User')</option>
                            <option value="{{ $model::TYPE_ADMIN }}">@lang('Administrator')</option>
                        </select>

                        <label for="type">@lang('Please select user type')</label>
                    </div><!--form-floating-->

                    <div class="form-floating mb-3">
                        <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name') }}" maxlength="100" required />

                        <label for="name">@lang('Name')</label>
                    </div><!--form-floating-->

                    <div class="form-floating mb-3">
                        <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ old('email') }}" maxlength="255" required />

                        <label for="email">@lang('E-mail Address')</label>
                    </div><!--form-floating-->

                    <div class="form-floating mb-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password') }}" maxlength="100" required autocomplete="new-password" />

                        <label for="password">@lang('Password')</label>
                    </div><!--form-floating-->

                    <div class="form-floating mb-3">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Password Confirmation') }}" maxlength="100" required autocomplete="new-password" />

                        <label for="password_confirmation">@lang('Password Confirmation')</label>
                    </div><!--form-floating-->

                    <div class="form-check form-switch form-switch-xl mb-3 mx-2">
                        <input name="active" id="active" class="form-check-input" type="checkbox" role="switch" value="1" {{ old('active', true) ? 'checked' : '' }} />

                        <label for="active" class="form-check-label">@lang('Active')</label>
                    </div><!--form-check-->

                    <div x-data="{ emailVerified : false }">
                        <div class="form-check form-switch form-switch-xl mb-3 mx-2">
                            <input name="email_verified" id="email_verified" class="form-check-input" type="checkbox" role="switch" value="1" x-on:click="emailVerified = !emailVerified" {{ old('email_verified') ? 'checked' : '' }} />

                            <label for="email_verified" class="form-check-label">@lang('E-mail Verified')</label>
                        </div><!--form-check-->

                        <div x-show="!emailVerified">
                            <div class="form-check form-switch form-switch-xl mb-3 mx-2">
                                <input name="send_confirmation_email" id="send_confirmation_email" class="form-check-input" type="checkbox" role="switch" value="1" {{ old('send_confirmation_email') ? 'checked' : '' }} />

                                <label for="send_confirmation_email" class="form-check-label">@lang('Send Confirmation E-mail')</label>
                            </div><!--form-check-->
                        </div>
                    </div>

                    @include('backend.auth.includes.roles')

                    @if (!config('template.access.user.only_roles'))
                        @include('backend.auth.includes.permissions')
                    @endif
                </div>
            </x-slot>

            <x-slot name="footer" class="text-end">
                <button class="btn btn-lg btn-primary" type="submit">@lang('Create User')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
