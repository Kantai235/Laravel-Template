@extends('backend.layouts.app')

@section('title', __('Short Urls Management'))

@section('breadcrumb-links')
    @include('backend.shorturls.includes.breadcrumb-links')
@endsection

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Short Urls Management')
        </x-slot>

        @if ($logged_in_user->hasAllAccess() ||
             $logged_in_user->can('admin.shorturls') ||
             $logged_in_user->can('admin.shorturls.list') ||
             $logged_in_user->can('admin.shorturls.deactivate') ||
             $logged_in_user->can('admin.shorturls.reactivate'))
            <x-slot name="headerActions">
                <x-utils.link
                    icon="c-icon cil-plus"
                    class="nav-link"
                    :href="route('admin.shorturls.create')"
                    :text="__('Create Short Urls')"
                />
            </x-slot>
        @endif

        <x-slot name="body">
            @livewire('backend.shorturls-table')
        </x-slot>
    </x-backend.card>
@endsection
