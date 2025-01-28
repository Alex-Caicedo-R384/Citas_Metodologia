<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Notificaciones de citas -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">{{ __('Your Appointments') }}</h3>
                @if($appointments->isNotEmpty())
                    <ul class="list-disc pl-5">
                        @foreach($appointments as $appointment)
                            <li class="flex justify-between items-center text-gray-700 dark:text-gray-300">
                                <span>
                                    {{ __('Appointment with') }} {{ $appointment['partner_name'] }} - {{ $appointment['date'] }}
                                </span>
                                <form method="POST" action="{{ route('appointments.destroy', $appointment['id']) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this appointment?') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <x-primary-button class="bg-red-600 hover:bg-red-700 focus:ring-red-500 focus:ring-2 focus:ring-offset-2">
                                        {{ __('Delete') }}
                                    </x-primary-button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">{{ __('No appointments yet.') }}</p>
                @endif
            </div>


            <!-- Filtros y usuarios -->
            <div class="mb-6">
                <form method="GET" action="{{ route('dashboard') }}" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">{{ __('Filter Users') }}</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="mb-4">
                            <x-input-label for="gender" :value="__('Gender')" />
                            <select id="gender" name="gender" class="block mt-1 w-full border rounded-md shadow-sm">
                                <option value="">{{ __('Select Gender') }}</option>
                                <option value="Hombre" {{ request('gender') == 'Hombre' ? 'selected' : '' }}>{{ __('Hombre') }}</option>
                                <option value="Mujer" {{ request('gender') == 'Mujer' ? 'selected' : '' }}>{{ __('Mujer') }}</option>
                                <option value="Otro" {{ request('gender') == 'Otro' ? 'selected' : '' }}>{{ __('Otro') }}</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="bio" :value="__('Search in Bio')" />
                            <x-text-input id="bio" class="block mt-1 w-full" type="text" name="bio" value="{{ request('bio') }}" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="bg-indigo-600">
                            {{ __('Apply Filters') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            @if($users->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($users as $user)
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow-lg p-4">
                            <h4 class="font-semibold text-lg text-gray-900 dark:text-gray-100">{{ $user->name }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->profile->location ?? __('Location not available') }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Age') }}: {{ $user->age ?? __('N/A') }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-300">{{ Str::limit($user->profile->bio, 100) }}</p>

                            <form method="POST" action="{{ route('appointments.store') }}" class="mt-4">
                                @csrf
                                <input type="hidden" name="partner_id" value="{{ $user->id }}">
                                <x-text-input type="date" name="date" class="block w-full" required />
                                <x-primary-button class="bg-green-600 mt-2">{{ __('Schedule Appointment') }}</x-primary-button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">{{ __('No users found. Try adjusting filters.') }}</p>
            @endif
        </div>
    </div>
</x-app-layout>
