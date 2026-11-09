@extends('default.layouts.layout')

@php
    $status = $exception->getStatusCode();
    $errorTitle = __('theme::messages.errors.' . match ($status) {
        403 => 'forbidden',
        404 => 'not_found',
        419 => 'expired',
        429 => 'rate_limited',
        default => 'unavailable',
    });
@endphp

@section('title', $errorTitle)
@section('robots', 'noindex,nofollow')

@section('content')
    <section class="card horizon-error text-center" aria-labelledby="horizon-error-title">
        <div class="card-body p-4 p-sm-5">
            <p class="horizon-error-code">{{ $status }}</p>
            <h1 id="horizon-error-title" class="mb-4">{{ $errorTitle }}</h1>
            <a class="btn btn-primary" href="{{ url('/') }}">
                <i class="bi bi-arrow-left me-1" aria-hidden="true"></i> {{ __('site.home.back_to_home') }}
            </a>
        </div>
    </section>
@endsection
