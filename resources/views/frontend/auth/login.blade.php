@extends('frontend.layouts.app')

@section('title', __('Login'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('Login')
                    </x-slot>

                    <x-slot name="body">
                        <x-forms.post :action="route('frontend.auth.login')">
                            <!-- E-mail input -->
                            <div class="mb-3">
                                <label for="email" class="form-label mb-1">@lang('E-mail Address')</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" maxlength="255" aria-describedby="emailHelp" required autofocus autocomplete="email" />
                                <div id="emailHelp" class="form-text">@lang('We\'ll never share your email with anyone else.')</div>
                            </div>

                            <!-- Password input -->
                            <div class="mb-3">
                                <label for="password" class="form-label mb-1">@lang('Password')</label>
                                <input type="password" name="password" id="password" class="form-control" aria-describedby="passwordHelpBlock" maxlength="100" required autocomplete="current-password" />
                                <div id="passwordHelpBlock" class="form-text">@lang('Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.')</div>
                            </div>

                            <!-- 2 column grid layout for inline styling -->
                            <div class="row mb-3">
                                <div class="col">
                                    <!-- Remember Me -->
                                    <div class="form-check">
                                        <input name="remember" id="remember" class="form-check-input" type="checkbox" {{ old('remember') ? 'checked' : '' }} />
                                        <label class="form-check-label" for="remember">@lang('Remember Me')</label>
                                    </div>
                                </div>

                                <div class="col d-flex justify-content-end">
                                    <!-- Forgot Password Link -->
                                    <x-utils.link :href="route('frontend.auth.password.request')" class="btn btn-link" :text="__('Forgot Your Password?')" />
                                </div>
                            </div>

                            @if(config('template.access.captcha.login'))
                                @captcha
                                <input type="hidden" name="captcha_status" value="true" />
                            @endif

                            <!-- Sign in button -->
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">@lang('Login')</button>
                            </div>

                            <div class="mb-3">
                                <span>
                                    @lang('Don\'t have an account?')
                                    <x-utils.link :href="route('frontend.auth.register')" class="btn btn-link" :text="__('Register here')" />
                                </span>
                            </div>

                            <div class="text-center">
                                @include('frontend.auth.includes.social')
                            </div>
                        </x-forms.post>
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-8-->
        </div><!--row-->
    </div><!--container-->
@endsection
