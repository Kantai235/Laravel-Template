@inject('model', '\App\Domains\Auth\Models\User')

@extends('backend.layouts.app')

@section('title', __('Update Role'))

@section('content')
    <x-forms.patch :action="route('admin.auth.role.update', $role)">
        <x-backend.card>
            <x-slot name="header">
                @lang('Update Role')
            </x-slot>

            <x-slot name="headerActions">
                <li class="nav-item">
                    <x-utils.link class="nav-link" :href="route('admin.auth.role.index')" :text="__('Cancel')" />
                </li><!--nav-item-->
            </x-slot>

            <x-slot name="body">
                <div x-data="{userType : '{{ $role->type }}'}">
                    <div class="form-floating mb-3">
                        <select name="type" id="type" class="form-control" required x-on:change="userType = $event.target.value">
                            <option value="{{ $model::TYPE_USER }}" {{ $role->type === $model::TYPE_USER ? 'selected' : '' }}>@lang('User')</option>
                            <option value="{{ $model::TYPE_ADMIN }}" {{ $role->type === $model::TYPE_ADMIN ? 'selected' : '' }}>@lang('Administrator')</option>
                        </select>

                        <label for="type">@lang('Please select user type')</label>
                    </div><!--form-floating-->

                    <div class="form-floating mb-3">
                        <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name') ?? $role->name }}" maxlength="100" required />

                        <label for="name">@lang('Name')</label>
                    </div><!--form-floating-->

                    @include('backend.auth.includes.permissions')
                </div>
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-lg btn-primary float-right" type="submit">@lang('Update Role')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.patch>
@endsection
