@extends('default.layouts.layout')
@use('App\Kraft\SocialLinks')
@section('horizon-body-class', 'horizon-landing')
@section('horizon-main-class', 'horizon-home')
@section('content')
    @php
        $publicAddress = $publicSite['communityAddress'];
        $onlinePlayers = $communityConnection['players_online'];
        $playerCapacity = $communityConnection['players_max'];
        $socialLinks = app(SocialLinks::class)->visible();
        $siteLogo = $publicSite['logo'];
    @endphp
    <x-extensions.slot name="site.home.before" :context="['news' => $news]" />
    <section class="horizon-hero" aria-labelledby="horizon-heading">
        <picture class="horizon-hero-art" aria-hidden="true">
            <source media="(max-width: 767.98px)"
                srcset="{{ route('site.extensions.assets.show', ['id' => $themeManifest['id'], 'asset' => 'images/highlands-mobile.webp']) }}">
            <img src="{{ route('site.extensions.assets.show', ['id' => $themeManifest['id'], 'asset' => 'images/highlands.webp']) }}"
                width="1920" height="768" alt="" fetchpriority="high">
        </picture>
        <div class="horizon-hero-inner">
            <div class="horizon-hero-copy">
                <h1 id="horizon-heading">
                    @if ($siteLogo)
                        <img class="horizon-hero-logo" src="{{ route('site.media.show', $siteLogo) }}"
                            width="{{ $siteLogo->width }}" height="{{ $siteLogo->height }}" alt="{{ $siteName }}">
                    @else
                        {{ $publicSite['homeTitle'] ?: $siteName }}
                    @endif
                </h1>
                <p class="horizon-hero-description">
                    {{ $publicSite['homeDescription'] ?: $publicSite['description'] ?: __('theme::messages.home.welcome.tagline') }}
                </p>
                <div class="horizon-hero-action" id="community-connection">
                    @if ($publicAddress)
                        <button class="btn btn-primary horizon-server-copy" type="button" data-copy="{{ $publicAddress }}"
                            data-copied="{{ __('site.home.copied') }}" aria-live="polite">
                            <span class="horizon-server-address">{{ $publicAddress }}</span>
                            <span class="horizon-copy-caption"><i class="bi bi-copy" aria-hidden="true"></i>
                                {{ __('theme::messages.home.welcome.copy_address') }}</span>
                        </button>
                    @elseif (auth()->check())
                        <a class="btn btn-primary" href="{{ route('account.index') }}">{{ __('site.auth.account.title') }}</a>
                    @elseif ($capabilities->canRegister)
                        <a class="btn btn-primary" href="{{ route('register') }}">{{ __('theme::messages.home.welcome.register') }}</a>
                    @else
                        <a class="btn btn-primary" href="{{ route('login') }}">{{ __('common.labels.login') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section class="horizon-community" aria-labelledby="community-heading">
        <div class="horizon-community-inner">
            <img class="horizon-community-art"
                src="{{ route('site.extensions.assets.show', ['id' => $themeManifest['id'], 'asset' => 'images/expedition-kit.webp']) }}"
                width="280" height="280" alt="" loading="lazy" decoding="async">
            <div class="horizon-community-intro">
                <p class="horizon-kicker">{{ __('theme::messages.home.welcome.kicker') }}</p>
                <h2 id="community-heading">{{ __('theme::messages.home.community.title') }}</h2>
                <p>{{ __('theme::messages.home.community.description') }}</p>
                @if ($onlinePlayers !== null)
                    <p class="horizon-population">
                        <i class="bi bi-broadcast-pin" aria-hidden="true"></i>
                        <strong>{{ number_format($onlinePlayers) }}@if ($playerCapacity !== null) / {{ number_format($playerCapacity) }}@endif</strong>
                        {{ __('site.home.players_online') }}
                    </p>
                @endif
                @if ($socialLinks)
                    <nav class="horizon-community-links" aria-label="{{ __('admin.social.title') }}">
                        @foreach ($socialLinks as $link)
                            <a class="btn btn-light" href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer me">
                                <i class="bi bi-{{ $link['icon'] }} me-1" aria-hidden="true"></i>
                                {{ $link['type'] === 'discord' ? __('theme::messages.home.community.join_discord') : $link['title'] }}
                                <span class="visually-hidden">{{ __('admin.social.new_tab') }}</span>
                            </a>
                        @endforeach
                    </nav>
                @endif
            </div>
        </div>
    </section>
    @include('default.home.partials.slider')
    @include('default.home.partials.welcome')
    @if ($capabilities->hasNews)
        <section class="horizon-news" id="news" aria-labelledby="news-heading">
            <div class="horizon-section-heading">
                <div>
                    <p class="horizon-kicker">{{ __('theme::messages.home.news.kicker') }}</p>
                    <h2 id="news-heading">{{ __('theme::messages.home.news.title') }}</h2>
                </div>
                <a class="btn btn-outline-primary" href="{{ route('site.news.index') }}">
                    {{ __('site.home.all_news') }} <i class="bi bi-arrow-right ms-1" aria-hidden="true"></i>
                </a>
            </div>
            <div id="home-news-list" data-ajax-pagination tabindex="-1">
                <div class="horizon-news-feed">
                    @foreach ($news as $entry)
                        @include('default.content.partials.card')
                    @endforeach
                </div>
                <div class="mt-4">{{ $news->links() }}</div>
            </div>
        </section>
    @endif
    <x-widgets.zone name="home" :context="['news' => $news]" />
    <x-extensions.slot name="site.home.after" :context="['news' => $news]" />
@endsection
