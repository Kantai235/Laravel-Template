<x-forms.patch :action="route('frontend.user.profile.update')">
    @if ($logged_in_user->canChangeEmail())
        <!-- E-mail input -->
        <div class="mb-3">
            <label for="email" class="form-label mb-1">@lang('E-mail Address')</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') ?? $logged_in_user->email }}" maxlength="255" aria-describedby="emailHelp" required autocomplete="email" />
            <div id="emailHelp" class="form-text">@lang('If you change your e-mail you will be logged out until you confirm your new e-mail address.')</div>
        </div>
    @endif

    <!-- Name input -->
    <div class="mb-3">
        <label for="name" class="form-label mb-1">@lang('Name')</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') ?? $logged_in_user->name }}" maxlength="100" required autofocus autocomplete="name" />
    </div>

    <!-- Update button -->
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">@lang('Update')</button>
    </div>
</x-forms.patch>
