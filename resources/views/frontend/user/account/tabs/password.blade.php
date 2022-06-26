<x-forms.patch :action="route('frontend.auth.password.change')">
    <!-- Password input -->
    <div class="mb-3">
        <label for="current_password" class="form-label mb-1">@lang('Current Password')</label>
        <input type="password" name="current_password" id="current_password" class="form-control" aria-describedby="passwordHelpBlock" maxlength="100" required autofocus autocomplete="current-password" />
    </div>

    <!-- Password input -->
    <div class="mb-3">
        <label for="password" class="form-label mb-1">@lang('New Password')</label>
        <input type="password" name="password" id="password" class="form-control" aria-describedby="passwordHelpBlock" maxlength="100" required autocomplete="new-password" />
        <div id="passwordHelpBlock" class="form-text">@lang('Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.')</div>
    </div>

    <!-- Password Confirmation input -->
    <div class="mb-3">
        <label for="password_confirmation" class="form-label mb-1">@lang('Password Confirmation')</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" aria-describedby="passwordConfirmationHelpBlock" maxlength="100" required autocomplete="new-password" />
        <div id="passwordConfirmationHelpBlock" class="form-text">@lang('Please confirm your password before continuing.')</div>
    </div>

    <!-- Update button -->
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">@lang('Update Password')</button>
    </div>
</x-forms.patch>
