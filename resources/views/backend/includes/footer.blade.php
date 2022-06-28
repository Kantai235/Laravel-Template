<footer class="footer">
    <div>
        <strong>
            @lang('Copyright') &copy; {{ date('Y') }}
            <x-utils.link href="http://laravel-template.com" target="_blank" :text="__(appName())" />
        </strong>

        @lang('All Rights Reserved')
    </div><!--copyright-->

    <div class="ms-auto">
        @lang('Powered by')
        <x-utils.link href="http://laravel-template.com" target="_blank" :text="__(appName())" /> &
        <x-utils.link href="https://coreui.io" target="_blank" text="CoreUI UI Components" />
    </div><!--ms-auto-->
</footer><!--footer-->
