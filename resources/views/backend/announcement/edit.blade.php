@inject('model', '\App\Domains\Announcement\Models\Announcement')

@extends('backend.layouts.app')

@section('title', __('Update Announcement'))

@push('before-styles')
    <style>
        .table > tbody > tr > th {
            vertical-align: middle;
        }
    </style>
@endpush

@push('before-scripts')
    <script>
        window.onload = function() {
            let messageElement = document.getElementById('message');
            messageElement.onkeyup = function() {
                let messageDemoElemennts = document.getElementsByClassName("message-demo");
                for(var i=0; i<messageDemoElemennts.length; i++) {
                    messageDemoElemennts[i].innerHTML = messageElement.value;
                }
            }
        }
    </script>
@endpush

@section('content')
    <x-forms.patch :action="route('admin.announcement.update', $announcement)">
        <x-backend.card>
            <x-slot name="header">
                @lang('Update Announcement')
            </x-slot>

            <x-slot name="headerActions">
                <li class="nav-item">
                    <x-utils.link class="nav-link" :href="route('admin.announcement.index')" :text="__('Cancel')" />
                </li><!--nav-item-->
            </x-slot>

            <x-slot name="body">
                <div class="form-floating mb-3">
                    <select name="area" id="area" class="form-control" required>
                        <option value="all" {{ $announcement->area === null ? 'selected' : '' }}>@lang('All')</option>
                        <option value="{{ $model::AREA_FRONTEND }}" {{ $announcement->area === $model::AREA_FRONTEND ? 'selected' : '' }}>@lang('Frontend')</option>
                        <option value="{{ $model::AREA_BACKEND }}" {{ $announcement->area === $model::AREA_BACKEND ? 'selected' : '' }}>@lang('Backend')</option>
                    </select>

                    <label for="area">@lang('Please select announcement area')</label>
                </div><!--form-floating-->

                <div class="form-floating mb-3">
                    <textarea name="message" id="message" class="form-control" style="height: 100px" placeholder="{{ __('Leave a comment here.') }}" value="{{ old('message') }}" required>{{ $announcement->message }}</textarea>

                    <label for="message">@lang('Message')</label>
                </div><!--form-floating-->

                <div class="form-group row mb-3">
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="date" name="starts_at_date" id="starts_at_date" class="form-control" placeholder="{{ __('Starts at DATE') }}" value="{{ isset($announcement->starts_at) ? $announcement->starts_at->toDateString() : null }}" />

                            <label for="starts_at_date">@lang('Start at DATE')</label>
                        </div><!--form-floating-->
                    </div>

                    <div class="col-6">
                        <div class="form-floating">
                            <input type="time" name="starts_at_time" id="starts_at_time" class="form-control" placeholder="{{ __('Starts at TIME') }}" value="{{ isset($announcement->starts_at) ? $announcement->starts_at->toTimeString() : null }}" />

                            <label for="starts_at_time">@lang('Start at TIME')</label>
                        </div><!--form-floating-->
                    </div>
                </div><!--form-group-->

                <div class="form-group row mb-3">
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="date" name="ends_at_date" id="ends_at_date" class="form-control" placeholder="{{ __('Ends at DATE') }}" value="{{ isset($announcement->ends_at) ? $announcement->ends_at->toDateString() : null }}" />

                            <label for="ends_at_date">@lang('Ends at DATE')</label>
                        </div><!--form-floating-->
                    </div>

                    <div class="col-6">
                        <div class="form-floating">
                            <input type="time" name="ends_at_time" id="ends_at_time" class="form-control" placeholder="{{ __('Ends at TIME') }}" value="{{ isset($announcement->ends_at) ? $announcement->ends_at->toTimeString() : null }}" />

                            <label for="ends_at_time">@lang('Ends at TIME')</label>
                        </div><!--form-floating-->
                    </div>
                </div><!--form-group-->

                <div class="form-check form-switch form-switch-xl mb-3 mx-2">
                    <input name="enabled" id="enabled" class="form-check-input" type="checkbox" role="switch" value="1" {{ old('enabled', $announcement->isEnabled()) ? 'checked' : '' }} />

                    <label for="enabled" class="form-check-label">@lang('Enabled')</label>
                </div><!--form-check-->

                <div class="form-check form-switch form-switch-xl mb-3 mx-2">
                    <input name="dismissable" id="dismissable" class="form-check-input" type="checkbox" role="switch" value="1" {{ old('dismissable', $announcement->isDismissable()) ? 'checked' : '' }} />

                    <label for="dismissable" class="form-check-label">@lang('Dismissable')</label>
                </div><!--form-check-->

                <div class="form-check">
                    <input class="form-check-input p-2 mt-4" type="radio" name="type" id="type_primary" value="{{ $model::TYPE_PRIMARY }}" {{ $announcement->type === $model::TYPE_PRIMARY ? 'checked' : '' }} />
                    <label class="alert alert-primary w-100 m-1 message-demo" for="type_primary" role="alert">Message</label>
                </div><!--form-check-->

                <div class="form-check">
                    <input class="form-check-input p-2 mt-4" type="radio" name="type" id="type_secondary" value="{{ $model::TYPE_SECONDARY }}" {{ $announcement->type === $model::TYPE_SECONDARY ? 'checked' : '' }} />
                    <label class="alert alert-secondary w-100 m-1 message-demo" for="type_secondary" role="alert">Message</label>
                </div><!--form-check-->

                <div class="form-check">
                    <input class="form-check-input p-2 mt-4" type="radio" name="type" id="type_success" value="{{ $model::TYPE_SUCCESS }}" {{ $announcement->type === $model::TYPE_SUCCESS ? 'checked' : '' }} />
                    <label class="alert alert-success w-100 m-1 message-demo" for="type_success" role="alert">Message</label>
                </div><!--form-check-->

                <div class="form-check">
                    <input class="form-check-input p-2 mt-4" type="radio" name="type" id="type_danger" value="{{ $model::TYPE_DANGER }}" {{ $announcement->type === $model::TYPE_DANGER ? 'checked' : '' }} />
                    <label class="alert alert-danger w-100 m-1 message-demo" for="type_danger" role="alert">Message</label>
                </div><!--form-check-->

                <div class="form-check">
                    <input class="form-check-input p-2 mt-4" type="radio" name="type" id="type_warning" value="{{ $model::TYPE_WARNING }}" {{ $announcement->type === $model::TYPE_WARNING ? 'checked' : '' }} />
                    <label class="alert alert-warning w-100 m-1 message-demo" for="type_warning" role="alert">Message</label>
                </div><!--form-check-->

                <div class="form-check">
                    <input class="form-check-input p-2 mt-4" type="radio" name="type" id="type_info" value="{{ $model::TYPE_INFO }}" {{ $announcement->type === $model::TYPE_INFO ? 'checked' : '' }} />
                    <label class="alert alert-info w-100 m-1 message-demo" for="type_info" role="alert">Message</label>
                </div><!--form-check-->

                <div class="form-check">
                    <input class="form-check-input p-2 mt-4" type="radio" name="type" id="type_light" value="{{ $model::TYPE_LIGHT }}" {{ $announcement->type === $model::TYPE_LIGHT ? 'checked' : '' }} />
                    <label class="alert alert-light w-100 m-1 message-demo" for="type_light" role="alert">Message</label>
                </div><!--form-check-->

                <div class="form-check">
                    <input class="form-check-input p-2 mt-4" type="radio" name="type" id="type_dark" value="{{ $model::TYPE_DARK }}" {{ $announcement->type === $model::TYPE_DARK ? 'checked' : '' }} />
                    <label class="alert alert-dark w-100 m-1 message-demo" for="type_dark" role="alert">Message</label>
                </div><!--form-check-->
            </x-slot>

            <x-slot name="footer" class="text-end">
                <button class="btn btn-lg btn-primary" type="submit">@lang('Update Announcement')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.patch>
@endsection
