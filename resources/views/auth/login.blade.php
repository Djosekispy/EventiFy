<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    Bem-vindo de volta!
                </h1>
                <p class="text-sm text-gray-600">
                    Faça login para acessar sua conta e aproveitar todos os recursos.
                </p>
            </div>
        </x-slot>

        <!-- Validation Errors -->
        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" value="{{ __('Email') }}" class="text-base font-semibold text-gray-700" />
                <x-input id="email" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                         type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Digite seu email" />
            </div>

            <!-- Password -->
            <div>
                <x-label for="password" value="{{ __('Senha') }}" class="text-base font-semibold text-gray-700" />
                <x-input id="password" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                         type="password" name="password" required autocomplete="current-password" placeholder="Digite sua senha" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <x-checkbox id="remember_me" name="remember" />
                <label for="remember_me" class="ms-2 text-sm text-gray-600">
                    {{ __('Lembrar-me') }}
                </label>
            </div>

            <!-- Actions -->
            <div class="flex flex-col items-center space-y-2 sm:flex-row sm:justify-between sm:space-y-0">
                <div class="text-sm text-gray-600">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-indigo-600 hover:underline">
                            {{ __('Esqueceu sua senha?') }}
                        </a>
                    @endif
                </div>
                <div class="text-sm text-gray-600">
                    <a href="/register" class="text-indigo-600 hover:underline">
                        {{ __('Criar Conta') }}
                    </a>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <x-button class="w-full py-2 text-lg font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                    {{ __('Entrar') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
