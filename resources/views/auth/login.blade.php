<x-guest-layout>
    <div class="max-w-md mx-auto mt-10 bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
            🔐 Bejelentkezés a fiókhoz
        </h2>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-sm text-green-600 text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email cím')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Jelszó')" />
                <x-text-input id="password" class="block mt-1 w-full"
                    type="password" name="password"
                    required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Emlékezz rám') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-sm text-blue-600 hover:underline focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md">
                        {{ __('Elfelejtett jelszó?') }}
                    </a>
                @endif
            </div>

            <!-- Submit -->
            <div class="flex justify-end mt-6">
                <x-primary-button class="w-full justify-center">
                    {{ __('Bejelentkezés') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
