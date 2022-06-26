@extends('frontend.layouts.app')

@section('title', __('Reset Password'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('Reset Password')
                    </x-slot>

                    <x-slot name="body">
                        <x-forms.post :action="route('frontend.auth.password.email')">
                            <!-- E-mail input -->
                            <div class="mb-3">
                                <label for="email" class="form-label mb-1">@lang('E-mail Address')</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" maxlength="255" required autofocus autocomplete="email" />
                            </div>

                            <!-- Send Password Reset Link button -->
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">@lang('Send Password Reset Link')</button>
                            </div>
                        </x-forms.post>
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-8-->
        </div><!--row-->
    </div><!--container-->
@endsection
