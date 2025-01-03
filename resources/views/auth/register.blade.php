<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    Crie sua conta
                </h1>
                <p class="text-sm text-gray-600">
                    Registre-se para começar a aproveitar todos os benefícios do nosso serviço.
                </p>
            </div>
        </x-slot>

        <!-- Validation Errors -->
        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" value="{{ __('Nome Completo') }}" class="text-base font-semibold text-gray-700" />
                <x-input id="name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                         type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Digite seu nome completo" />
            </div>

            <!-- Email -->
            <div>
                <x-label for="email" value="{{ __('Email') }}" class="text-base font-semibold text-gray-700" />
                <x-input id="email" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                         type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Digite seu email" />
            </div>

            <!-- Password -->
            <div>
                <x-label for="password" value="{{ __('Senha') }}" class="text-base font-semibold text-gray-700" />
                <x-input id="password" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                         type="password" name="password" required autocomplete="new-password" placeholder="Crie uma senha" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-label for="password_confirmation" value="{{ __('Confirme sua Senha') }}" class="text-base font-semibold text-gray-700" />
                <x-input id="password_confirmation" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                         type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repita a senha" />
            </div>

            <!-- Terms and Privacy -->
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="flex items-start">
                    <x-checkbox name="terms" id="terms" required />
                    <label for="terms" class="ms-2 text-sm text-gray-600">
                        {!! __('Eu concordo com os :terms_of_service e :privacy_policy', [
                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-indigo-600 hover:text-indigo-700">'.__('Termos de Serviço').'</a>',
                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-indigo-600 hover:text-indigo-700">'.__('Política de Privacidade').'</a>',
                        ]) !!}
                    </label>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex flex-col items-center space-y-2 sm:flex-row sm:justify-between sm:space-y-0">
                <div class="text-sm text-gray-600">
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">
                        {{ __('Já tem uma conta? Faça login') }}
                    </a>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <x-button class="w-full py-2 text-lg font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                    {{ __('Registrar') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
