<x-card-box-shadow-layout>
    <form id="registerForm" onsubmit="submitForm('registerForm')">
        @csrf
        <input type="hidden" name="_token" id="_csrf-token" />
        <input type="hidden" name="token" id="csrf-token" />

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                required autofocus autocomplete="name" />
            <ul class="hide_notif text-sm text-red-600 space-y-1 mt-2" id="err_name">
                <li></li>
            </ul>
        </div>

        <div class="mt-4">
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')"
                required autocomplete="username" />
            <ul class="hide_notif text-sm text-red-600 space-y-1 mt-2" id="err_username">
                <li></li>
            </ul>
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <ul class="hide_notif text-sm text-red-600 space-y-1 mt-2" id="err_email">
                <li></li>
            </ul>
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <ul class="hide_notif text-sm text-red-600 space-y-1 mt-2" id="err_password">
                <li></li>
            </ul>
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <ul class="hide_notif text-sm text-red-600 space-y-1 mt-2" id="err_password_confirmation">
                <li></li>
            </ul>
        </div>

        <div class="flex items-center justify-end mt-4">
            <p class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer"
                onclick="openSection('loginSection')">
                {{ __('Sudah terdaftar?') }}
            </p>

            <x-primary-button class="hideBtnProcess ms-4">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>
    </form>
</x-card-box-shadow-layout>
