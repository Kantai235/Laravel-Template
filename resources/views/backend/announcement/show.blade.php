@extends('backend.layouts.app')

@section('title', __('View Announcement'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('View Announcement')
        </x-slot>

        <x-slot name="headerActions">
            <li class="nav-item">
                <x-utils.link class="nav-link" :href="route('admin.announcement.index')" :text="__('Back')" />
            </li><!--nav-item-->
        </x-slot>

        <x-slot name="body">
            <x-utils.alert type="{{ $announcement->type }}" class="rounded-0" dismissable="{{ $announcement->dismissable }}">
                {!! $announcement->message !!}
            </x-utils.alert>

            <table class="table table-hover">
                <tr>
                    <th>@lang('Area')</th>
                    <td>
                        @include('backend.announcement.includes.area', ['announcement' => $announcement])
                    </td>
                </tr>
                <tr>
                    <th>@lang('Type')</th>
                    <td>
                        <span class="badge bg-{{ $announcement->type }}">{{ strtoupper($announcement->type) }}</span>
                    </td>
                </tr>
                <tr>
                    <th>@lang('Enabled Status')</th>
                    <td>
                        @include('backend.announcement.includes.status', ['announcement' => $announcement])
                    </td>
                </tr>
                <tr>
                    <th>@lang('Dismissable Status')</th>
                    <td>
                        @include('backend.announcement.includes.dismissable', ['announcement' => $announcement])
                    </td>
                </tr>
                <tr>
                    <th>@lang('Starts At')</th>
                    <td>
                        @include('backend.announcement.includes.starts', ['announcement' => $announcement])
                    </td>
                </tr>
                <tr>
                    <th>@lang('Ends At')</th>
                    <td>
                        @include('backend.announcement.includes.ends', ['announcement' => $announcement])
                    </td>
                </tr>
            </table>
        </x-slot>

        <x-slot name="footer">
            <small class="float-right text-muted">
                <strong>@lang('Announcement Created'):</strong> @displayDate($announcement->created_at) ({{ $announcement->created_at->diffForHumans() }}),
                <strong>@lang('Last Updated'):</strong> @displayDate($announcement->updated_at) ({{ $announcement->updated_at->diffForHumans() }})

                @if($announcement->trashed())
                    <strong>@lang('Announcement Deleted'):</strong> @displayDate($announcement->deleted_at) ({{ $announcement->deleted_at->diffForHumans() }})
                @endif
            </small>
        </x-slot>
    </x-backend.card>
@endsection
