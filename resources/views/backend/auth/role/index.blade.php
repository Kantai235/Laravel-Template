@extends('backend.layouts.app')

@section('title', __('Role Management'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Role Management')
        </x-slot>

        <x-slot name="headerActions">
            <li class="nav-item">
                <x-utils.link
                    icon="c-icon cil-plus"
                    class="nav-link"
                    :href="route('admin.auth.role.create')"
                    :text="__('Create Role')"
                />
            </li><!--nav-item-->
        </x-slot>

        <x-slot name="body">
            @livewire('backend.roles-table')
        </x-slot>
    </x-backend.card>
@endsection
