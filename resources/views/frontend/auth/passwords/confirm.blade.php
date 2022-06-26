@extends('frontend.layouts.app')

@section('title', __('Please confirm your password before continuing.'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('Please confirm your password before continuing.')
                    </x-slot>

                    <x-slot name="body">
                        <x-forms.post :action="route('frontend.auth.password.confirm')">
                            <!-- Password input -->
                            <div class="mb-3">
                                <label for="password" class="form-label mb-1">@lang('Password')</label>
                                <input type="password" name="password" id="password" class="form-control" maxlength="100" required autocomplete="current-password" />
                            </div>

                            <!-- Confirm Password button -->
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">@lang('Confirm Password')</button>
                            </div>
                        </x-forms.post>
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-8-->
        </div><!--row-->
    </div><!--container-->
@endsection
