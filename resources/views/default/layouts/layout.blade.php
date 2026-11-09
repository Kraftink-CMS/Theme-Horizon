<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-bs-theme="{{ $appearance['effective'] }}"
    data-appearance="{{ $appearance['choice'] }}">
<!--suppress HtmlRequiredTitleElement -->
<head>
    @include('default.layouts.partials.head', [
        'themeColor' => $themeManifest['theme_color'],
        'stylesheet' => 'resources/scss/app.scss',
    ])
    @stack('head')
</head>
<body class="theme-horizon @yield('horizon-body-class')">
    <a class="visually-hidden-focusable position-absolute p-3 bg-white"
        href="#main-content">{{ __('site.home.skip_to_content') }}</a>
    <header class="site-header">
        <nav class="navbar navbar-expand-xxl" aria-label="{{ __('site.home.main_navigation') }}">
            <div class="container header-inner">
                <a class="horizon-wordmark" href="{{ url('/') }}"
                    aria-label="{{ $siteName }} · {{ __('common.labels.home') }}">
                    {{ $siteName }}
                </a>
                <div class="horizon-compact-actions d-xxl-none">
                    @if ($publicSite['communityAddress'])
                        <a class="btn btn-sm horizon-play-link"
                            href="{{ route('site.home.index') }}#community-connection">{{ __('theme::messages.navigation.play') }}</a>
                    @endif
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#site-menu"
                        aria-controls="site-menu" aria-expanded="false" data-site-toggle hidden>
                        <span class="horizon-menu-icon" aria-hidden="true"></span>
                        {{ __('common.labels.menu') }}
                    </button>
                </div>
                <div class="navbar-collapse" id="site-menu">
                    @include('default.layouts.partials.navigation-menu')
                </div>
            </div>
        </nav>
    </header>
    <main id="main-content" class="container site-content main-content @yield('horizon-main-class')">
        @include('partials.feedback.alerts')
        <x-extensions.slot name="site.page.before" />
        @yield('content')
        <x-extensions.slot name="site.page.after" />
    </main>
    @include('default.layouts.partials.footer')
    @stack('scripts')
</body>
</html>
