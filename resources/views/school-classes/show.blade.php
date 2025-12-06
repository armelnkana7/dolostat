@php
    $import = 'App\Livewire\SchoolClasses\Show';
@endphp

<x-layouts.app>
    @livewire('school-classes.show', ['id' => $schoolClass->id ?? request()->route('id')])
</x-layouts.app>
