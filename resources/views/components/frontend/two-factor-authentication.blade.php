<div>
    @error('code')
        <x-utils.alert type="danger">
            {{ $message }}
        </x-utils.alert>
    @enderror

    <form wire:submit.prevent="validateCode" class="form-horizontal">
        <!-- Authorization Code input -->
        <div class="mb-3">
            <label for="code" class="form-label mb-1">@lang('Authorization Code')</label>
            <input type="text" name="code" id="code" class="form-control" wire:model.lazy="code" minlength="6" required autofocus />
        </div>

        <!-- Submit button -->
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">@lang('Enable Two Factor Authentication')</button>
        </div>
    </form>
</div>
