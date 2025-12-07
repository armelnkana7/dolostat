@extends('layouts.saul')

@section('title', __('Tableau de Bord'))

@section('content')


    @if (auth()->user()->hasRole('admin'))
        @livewire('dashboard.admin')
    @elseif(auth()->user()->hasRole('censor'))
        @livewire('dashboard.censor')
    @elseif(auth()->user()->hasRole('animator'))
        @livewire('dashboard.animator')
    @else
        <div class="alert alert-info">{{ __('Accès non configuré') }}</div>
    @endif
@endsection
