<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Filtros -->
            <div class="mb-6">
                <form method="GET" action="{{ route('dashboard') }}" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">{{ __('Filter Users') }}</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="mb-4">
                            <x-input-label for="gender" :value="__('Gender')" />
                            <select id="gender" name="gender" class="block mt-1 w-full border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                                <option value="">{{ __('Selecciona un Género') }}</option>
                                <option value="Hombre" {{ request('gender') == 'Hombre' ? 'selected' : '' }}>{{ __('Hombre') }}</option>
                                <option value="Mujer" {{ request('gender') == 'Mujer' ? 'selected' : '' }}>{{ __('Mujer') }}</option>
                                <option value="Otro" {{ request('gender') == 'Otro' ? 'selected' : '' }}>{{ __('Otro') }}</option>
                            </select>
                        </div>

                        <!-- Filtro de Biografía -->
                        <div class="mb-4">
                            <x-input-label for="bio" :value="__('Search in Bio')" />
                            <x-text-input id="bio" class="block mt-1 w-full border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" type="text" name="bio" value="{{ request('bio') }}" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-2 focus:ring-offset-2">
                            {{ __('Apply Filters') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            @if($users->isNotEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-6">{{ __('Filtered Users') }}</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach($users as $user)
                                <div class="bg-white dark:bg-gray-700 rounded-lg shadow-lg p-4 hover:shadow-xl transition duration-300 ease-in-out">
                                    <div class="flex items-center space-x-4">
                                        <div class="space-y-1">
                                            <h4 class="font-semibold text-lg text-gray-900 dark:text-gray-100">{{ $user->name }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->profile->location ?? __('Location not available') }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Age') }}: {{ $user->age ?? __('N/A') }}</p>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">{{ Str::limit($user->bio, 100) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @elseif($noFiltersApplied)
                <p class="text-gray-500">{{ __('No hay usuarios encontrados aplica alguno de los filtros') }}</p>
            @endif

        </div>
    </div>
</x-app-layout>
