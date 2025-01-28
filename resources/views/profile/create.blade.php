<x-guest-layout>
    <form method="POST" action="{{ route('profile.store') }}">
        @csrf

        <!-- Nombre del perfil -->
        <div>
            <x-input-label for="name" :value="__('Profile Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Fecha de nacimiento -->
        <div class="mt-4">
            <x-input-label for="birth_date" :value="__('Birth Date')" />
            <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" required />
            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
        </div>

        <!-- Género -->
        <div class="mt-4">
            <x-input-label for="gender" :value="__('Gender')" />
            <select id="gender" name="gender" class="block mt-1 w-full" required>
                <option value="">{{ __('Select Gender') }}</option>
                <option value="Hombre">{{ __('Hombre') }}</option>
                <option value="Mujer">{{ __('Mujer') }}</option>
                <option value="Prefiero no decirlo">{{ __('Prefiero no decirlo') }}</option>
                <option value="Otro">{{ __('Otro') }}</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <!-- Ubicación -->
        <div class="mt-4">
            <x-input-label for="location" :value="__('Location')" />
            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" required />
            <x-input-error :messages="$errors->get('location')" class="mt-2" />
        </div>

        <!-- Biografía -->
        <div class="mt-4">
            <x-input-label for="bio" :value="__('Bio')" />
            <x-text-input id="bio" class="block mt-1 w-full" type="text" name="bio" />
            <x-input-error :messages="$errors->get('bio')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Save Profile') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
