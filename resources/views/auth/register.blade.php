@extends('includes.body')
@section('title', 'Registrar')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@section('content')

<div class="d-flex justify-content-center align-items-center m-4">
    <div class="shadow p-4 rounded" style="width: 100%; max-width: 500px;">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Criar uma Conta</h2>
            <p class="text-gray-600">Por favor, preencha os campos abaixo para criar sua conta.</p>
        </div>
        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700">Nome Completo</label>
                <input id="name" type="text" name="name" :value="old('name')" required autofocus
                    class="block w-full px-4 py-2 mt-2 border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="Digite seu nome completo" />
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                    class="block w-full px-4 py-2 mt-2 border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="Digite seu email" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700">Senha</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="block w-full px-4 py-2 mt-2 border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="Crie uma senha" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirme sua Senha</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="block w-full px-4 py-2 mt-2 border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="Repita a senha" />
            </div>

            <!-- Terms and Privacy -->
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div class="flex items-start mt-4">
                <input type="checkbox" name="terms" id="terms" required class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                <label for="terms" class="ml-2 text-sm text-gray-600">
                    {!! __('Eu concordo com os :terms_of_service e :privacy_policy', [
                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-indigo-600 hover:text-indigo-700">'.__('Termos de Serviço').'</a>',
                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-indigo-600 hover:text-indigo-700">'.__('Política de Privacidade').'</a>',
                    ]) !!}
                </label>
            </div>
            @endif

            <!-- Actions -->
            <div class="flex flex-col items-center space-y-2 sm:flex-row sm:justify-between sm:space-y-0 mt-4">
                <div class="text-sm text-gray-600">
                    <a href="{{ route('login') }}" class="text-decoration-none">
                        Já tem uma conta? Faça login
                    </a>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="w-full py-2 text-lg font-semibold text-white btn btn-dark btn-lg w-100">
                    Registrar
                </button>
            </div>
        </form>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
