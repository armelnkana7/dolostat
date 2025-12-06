@extends('layouts.saul')

@section('title', __('Tableau de Bord'))

@section('content')
    <div class="toolbar py-6" id="kt_toolbar">
        <div class="container-xxl d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 mb-0">
                    {{ __('Tableau de Bord') }}
                </h1>
                <span class="text-muted fs-6 fw-semibold mt-2">
                    {{ __('Bienvenue') }}, {{ auth()->user()->name }}
                </span>
            </div>
        </div>
    </div>

    <div class="post d-flex flex-column-fluid" id="kt_post">
        @if (auth()->user()->hasRole('admin'))
            @livewire('dashboard.admin')
        @elseif(auth()->user()->hasRole('censor'))
            @livewire('dashboard.censor')
        @elseif(auth()->user()->hasRole('animator'))
            @livewire('dashboard.animator')
        @else
            <div class="alert alert-info">{{ __('Accès non configuré') }}</div>
        @endif
    </div>
@endsection
