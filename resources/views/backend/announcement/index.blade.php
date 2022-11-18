@extends('backend.layouts.app')

@section('title', __('Announcement Management'))

@section('breadcrumb-links')
    @include('backend.announcement.includes.breadcrumb-links')
@endsection

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Announcement Management')
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link
                icon="c-icon cil-plus"
                class="nav-link"
                :href="route('admin.announcement.create')"
                :text="__('Create Announcement')"
                permission="admin.announcement.edit"
            />
        </x-slot>

        <x-slot name="body">
            @livewire('backend.announcement-table')
        </x-slot>
    </x-backend.card>
@endsection
