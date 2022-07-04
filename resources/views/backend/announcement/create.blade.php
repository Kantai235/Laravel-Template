@inject('model', '\App\Domains\Announcement\Models\Announcement')

@extends('backend.layouts.app')

@section('title', __('Create Announcement'))

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
    <x-forms.post :action="route('admin.announcement.store')">
        <x-backend.card>
            <x-slot name="header">
                @lang('Create Announcement')
            </x-slot>

            <x-slot name="headerActions">
                <li class="nav-item">
                    <x-utils.link class="nav-link" :href="route('admin.announcement.index')" :text="__('Cancel')" />
                </li><!--nav-item-->
            </x-slot>

            <x-slot name="body">
                <div class="form-floating mb-3">
                    <select name="area" id="area" class="form-control" required>
                        <option value="all">@lang('All')</option>
                        <option value="{{ $model::AREA_FRONTEND }}">@lang('Frontend')</option>
                        <option value="{{ $model::AREA_BACKEND }}">@lang('Backend')</option>
                    </select>

                    <label for="area">@lang('Please select announcement area')</label>
                </div><!--form-floating-->

                <div class="form-floating mb-3">
                    <textarea name="message" id="message" class="form-control" style="height: 100px" placeholder="{{ __('Leave a comment here.') }}" value="{{ old('message') }}" required></textarea>

                    <label for="message">@lang('Message')</label>
                </div><!--form-floating-->

                <div class="form-group row mb-3">
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="date" name="starts_at_date" id="starts_at_date" class="form-control" placeholder="{{ __('Starts at DATE') }}" value="{{ old('starts_at_date') }}" />

                            <label for="starts_at_date">@lang('Start at DATE')</label>
                        </div><!--form-floating-->
                    </div>

                    <div class="col-6">
                        <div class="form-floating">
                            <input type="time" name="starts_at_time" id="starts_at_time" class="form-control" placeholder="{{ __('Starts at TIME') }}" value="{{ old('starts_at_time') }}" />

                            <label for="starts_at_time">@lang('Start at TIME')</label>
                        </div><!--form-floating-->
                    </div>
                </div><!--form-group-->

                <div class="form-group row mb-3">
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="date" name="ends_at_date" id="ends_at_date" class="form-control" placeholder="{{ __('Ends at DATE') }}" value="{{ old('ends_at_date') }}" />

                            <label for="ends_at_date">@lang('Ends at DATE')</label>
                        </div><!--form-floating-->
                    </div>

                    <div class="col-6">
                        <div class="form-floating">
                            <input type="time" name="ends_at_time" id="ends_at_time" class="form-control" placeholder="{{ __('Ends at TIME') }}" value="{{ old('ends_at_time') }}" />

                            <label for="ends_at_time">@lang('Ends at TIME')</label>
                        </div><!--form-floating-->
                    </div>
                </div><!--form-group-->

                <div class="form-check form-switch form-switch-xl mb-3 mx-2">
                    <input name="enabled" id="enabled" class="form-check-input" type="checkbox" role="switch" value="1" {{ old('enabled', true) ? 'checked' : '' }} />

                    <label for="enabled" class="form-check-label">@lang('Enabled')</label>
                </div><!--form-check-->

                <div class="form-check">
                    <input class="form-check-input p-2 mt-4" type="radio" name="type" id="type_primary" value="{{ $model::TYPE_PRIMARY }}" checked />
                    <label class="alert alert-primary w-100 m-1 message-demo" for="type_primary" role="alert">Message</label>
                </div><!--form-check-->

                <div class="form-check">
                    <input class="form-check-input p-2 mt-4" type="radio" name="type" id="type_secondary" value="{{ $model::TYPE_SECONDARY }}" />
                    <label class="alert alert-secondary w-100 m-1 message-demo" for="type_secondary" role="alert">Message</label>
                </div><!--form-check-->

                <div class="form-check">
                    <input class="form-check-input p-2 mt-4" type="radio" name="type" id="type_success" value="{{ $model::TYPE_SUCCESS }}" />
                    <label class="alert alert-success w-100 m-1 message-demo" for="type_success" role="alert">Message</label>
                </div><!--form-check-->

                <div class="form-check">
                    <input class="form-check-input p-2 mt-4" type="radio" name="type" id="type_danger" value="{{ $model::TYPE_DANGER }}" />
                    <label class="alert alert-danger w-100 m-1 message-demo" for="type_danger" role="alert">Message</label>
                </div><!--form-check-->

                <div class="form-check">
                    <input class="form-check-input p-2 mt-4" type="radio" name="type" id="type_warning" value="{{ $model::TYPE_WARNING }}" />
                    <label class="alert alert-warning w-100 m-1 message-demo" for="type_warning" role="alert">Message</label>
                </div><!--form-check-->

                <div class="form-check">
                    <input class="form-check-input p-2 mt-4" type="radio" name="type" id="type_info" value="{{ $model::TYPE_INFO }}" />
                    <label class="alert alert-info w-100 m-1 message-demo" for="type_info" role="alert">Message</label>
                </div><!--form-check-->

                <div class="form-check">
                    <input class="form-check-input p-2 mt-4" type="radio" name="type" id="type_light" value="{{ $model::TYPE_LIGHT }}" />
                    <label class="alert alert-light w-100 m-1 message-demo" for="type_light" role="alert">Message</label>
                </div><!--form-check-->

                <div class="form-check">
                    <input class="form-check-input p-2 mt-4" type="radio" name="type" id="type_dark" value="{{ $model::TYPE_DARK }}" />
                    <label class="alert alert-dark w-100 m-1 message-demo" for="type_dark" role="alert">Message</label>
                </div><!--form-check-->
            </x-slot>

            <x-slot name="footer" class="text-end">
                <button class="btn btn-lg btn-primary" type="submit">@lang('Create Announcement')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
