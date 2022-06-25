<x-utils.link
    :href="route('frontend.auth.social.login', 'bitbucket')"
    class="btn btn-lg btn-bitbucket m-1 mt-2"
    style="min-width: 16rem;"
    icon="fab fa-bitbucket"
    :text="__('Sign in with Bitbucket')"
    :hide="!config('services.bitbucket.active')" />

<x-utils.link
    :href="route('frontend.auth.social.login', 'facebook')"
    class="btn btn-lg btn-facebook m-1 mt-2"
    style="min-width: 16rem;"
    icon="fab fa-facebook"
    :text="__('Sign in with Facebook')"
    :hide="!config('services.facebook.active')" />

<x-utils.link
    :href="route('frontend.auth.social.login', 'google')"
    class="btn btn-lg btn-google m-1 mt-2"
    style="min-width: 16rem;"
    icon="fab fa-google"
    :text="__('Sign in with Google')"
    :hide="!config('services.google.active')" />

<x-utils.link
    :href="route('frontend.auth.social.login', 'github')"
    class="btn btn-lg btn-github m-1 mt-2"
    style="min-width: 16rem;"
    icon="fab fa-github"
    :text="__('Sign in with GitHub')"
    :hide="!config('services.github.active')" />

<x-utils.link
    :href="route('frontend.auth.social.login', 'linkedin')"
    class="btn btn-lg btn-linkedin m-1 mt-2"
    style="min-width: 16rem;"
    icon="fab fa-linkedin"
    :text="__('Sign in with LinkedIn')"
    :hide="!config('services.linkedin.active')" />

<x-utils.link
    :href="route('frontend.auth.social.login', 'twitter')"
    class="btn btn-lg btn-twitter m-1 mt-2"
    style="min-width: 16rem;"
    icon="fab fa-twitter"
    :text="__('Sign in with Twitter')"
    :hide="!config('services.twitter.active')" />
