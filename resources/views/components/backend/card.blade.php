<div class="card">
    @if (isset($header))
        <header class="header mx-2">
            <a class="header-brand">{{ $header }}</a>

            @if (isset($headerActions))
                <ul class="header-nav">
                    {{ $headerActions }}
                </ul><!--header-nav-->
            @endif
        </header><!--header-->
    @endif

    @if (isset($body))
        <div class="card-body">
            {{ $body }}
        </div><!--card-body-->
    @endif

    @if (isset($footer))
        <div class="card-footer">
            {{ $footer }}
        </div><!--card-footer-->
    @endif
</div><!--card-->
