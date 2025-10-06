<x-app-layout>
    
    <x-slot name="header">
        <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
            {{ __('Timeline') }}
        </h1>
        <p class= "text-slate-500 dark:text-slate-400 mt-1">
           Welcome back, {{ Auth::user()->name }}! Let's get things done.
    
    </x-slot>

    
        
</x-app-layout>
