@extends('backend.layouts.app')

@section('title', __('User Management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('User Management')
        </x-slot>

        @if ($logged_in_user->hasAllAccess())
            <x-slot name="headerActions">
                <li class="nav-item">
                    <x-utils.link
                        icon="c-icon cil-plus"
                        class="nav-link"
                        :href="route('admin.auth.user.create')"
                        :text="__('Create User')"
                    />
                </li><!--nav-item-->
            </x-slot>
        @endif

        <x-slot name="body">
            @livewire('backend.users-table')
        </x-slot>
    </x-backend.card>
@endsection
