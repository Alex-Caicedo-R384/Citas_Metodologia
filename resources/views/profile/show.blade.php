<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Sección de visualización de la información del perfil -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <!-- Nombre -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Name')" />
                        <p class="text-gray-700 dark:text-gray-300 mt-1">{{ $user->name }}</p>
                    </div>

                    <!-- Correo Electrónico -->
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <p class="text-gray-700 dark:text-gray-300 mt-1">{{ $user->email }}</p>
                    </div>

                    <!-- Fecha de nacimiento -->
                    <div class="mb-4">
                        <x-input-label for="birth_date" :value="__('Birth Date')" />
                        <p class="text-gray-700 dark:text-gray-300 mt-1">{{ $user->profile->birth_date }}</p>
                    </div>

                    <!-- Género -->
                    <div class="mb-4">
                        <x-input-label for="gender" :value="__('Gender')" />
                        <p class="text-gray-700 dark:text-gray-300 mt-1">{{ $user->profile->gender }}</p>
                    </div>

                    <!-- Ubicación -->
                    <div class="mb-4">
                        <x-input-label for="location" :value="__('Location')" />
                        <p class="text-gray-700 dark:text-gray-300 mt-1">{{ $user->profile->location }}</p>
                    </div>

                    <!-- Biografía -->
                    <div class="mb-4">
                        <x-input-label for="bio" :value="__('Bio')" />
                        <p class="text-gray-700 dark:text-gray-300 mt-1">{{ $user->profile->bio }}</p>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <a href="{{ route('profile.edit') }}" class="inline-block bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg shadow-lg transition transform hover:bg-blue-700 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            {{ __('Edit Profile') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sección de cambiar la contraseña (si lo deseas agregar) -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Sección de eliminar cuenta (si lo deseas agregar) -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
