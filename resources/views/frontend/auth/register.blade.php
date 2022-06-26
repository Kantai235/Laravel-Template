@extends('frontend.layouts.app')

@section('title', __('Register'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('Register')
                    </x-slot>

                    <x-slot name="body">
                        <x-forms.post :action="route('frontend.auth.register')">
                            <!-- Name input -->
                            <div class="mb-3">
                                <label for="name" class="form-label mb-1">@lang('Name')</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" maxlength="100" required autofocus autocomplete="name" />
                            </div>

                            <!-- E-mail input -->
                            <div class="mb-3">
                                <label for="email" class="form-label mb-1">@lang('E-mail Address')</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" maxlength="255" aria-describedby="emailHelp" required autocomplete="email" />
                                <div id="emailHelp" class="form-text">@lang('We\'ll never share your email with anyone else.')</div>
                            </div>

                            <!-- Password input -->
                            <div class="mb-3">
                                <label for="password" class="form-label mb-1">@lang('Password')</label>
                                <input type="password" name="password" id="password" class="form-control" aria-describedby="passwordHelpBlock" maxlength="100" required autocomplete="new-password" />
                                <div id="passwordHelpBlock" class="form-text">@lang('Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.')</div>
                            </div>

                            <!-- Password Confirmation input -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label mb-1">@lang('Password Confirmation')</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" aria-describedby="passwordConfirmationHelpBlock" maxlength="100" required autocomplete="new-password" />
                                <div id="passwordConfirmationHelpBlock" class="form-text">@lang('Please confirm your password before continuing.')</div>
                            </div>

                            <!-- I agree to the Terms -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="terms" id="terms" value="1" class="form-check-input" required />
                                <label class="form-check-label" for="terms">
                                    @lang('I agree to the') <a href="{{ route('frontend.pages.terms') }}" target="_blank">@lang('Terms & Conditions')</a>
                                </label>
                            </div>

                            @if(config('template.access.captcha.registration'))
                                @captcha
                                <input type="hidden" name="captcha_status" value="true" />
                            @endif

                            <!-- Register button -->
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">@lang('Register')</button>
                            </div>
                        </x-forms.post>
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-8-->
        </div><!--row-->
    </div><!--container-->
@endsection
