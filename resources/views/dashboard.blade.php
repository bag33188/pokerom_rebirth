@push('scripts')
    <script <?= 'type="text/javascript"'; ?> src="{{ mix('js/modules/capitalize.js') }}"></script>
    <script <?= 'type="text/javascript"'; ?>>
        $(document).ready(function() {
            const welcomeEl = document.getElementById('welcome-username');
            welcomeEl.textContent = welcomeEl.textContent.capitalize(new CapitalizationOptions(true));
        });
    </script>
@endpush
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <div class="inline-flex flex-row w-full justify-between">
                <span>{{ __('Dashboard') }}</span>
                <span id="welcome-username">Welcome, {{$username}}!</span>
            </div>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-jet-welcome/>
            </div>
        </div>
    </div>
</x-app-layout>
