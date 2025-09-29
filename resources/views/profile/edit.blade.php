<x-app-layout>
    
<div class="max-w-4xl mx-auto">
    <div class="mb-12">
    <section>
<x-slot name="headerClass">max-w-4xl</x-slot>
    <x-slot name="header">
        <div class="mb-12">
        <h1 class="text-4xl font-bold text-slate-900 dark:text-white">
            {{ __('Settings') }}
        </h1>
        <p class= "text-slate-500 dark:text-slate-400 mt-2 text-lg">
           Manage your profile, preferences, and accessibility settings.
        </p>
    </x-slot>

     
    
        <div class="space-y-12">
            <div class="bg-white dark:bg-slate-900/70 rounded-xl shadow-sm p-8 space-y-6">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </section>
</div>
</x-app-layout>
