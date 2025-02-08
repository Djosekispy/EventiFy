@extends('includes.body')
@section('title', 'Registrar')
@section('content')

<div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="shadow-lg p-5 rounded" style="width: 100%; max-width: 450px;">
        <div class="text-center mb-4">
            <h2 class="h3 font-weight-bold text-dark">Criar uma Conta</h2>
            <p class="text-muted">Por favor, preencha os campos abaixo para criar sua conta.</p>
        </div>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="list-unstyled mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        
    @endif
        <form method="POST" action="{{ route('register') }}">
            @csrf
            @method('POST')
            <div class="mb-4">
                <label for="name" class="form-label">Nome Completo</label>
                <input id="name" type="text" name="name" :value="old('name')" required autofocus
                    class="form-control form-control-lg" placeholder="Digite seu nome completo" />
            </div>
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                    class="form-control form-control-lg" placeholder="Digite seu email" />
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Senha</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="form-control form-control-lg" placeholder="Crie uma senha" />
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirme sua Senha</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="form-control form-control-lg" placeholder="Repita a senha" />
            </div>
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div class="form-check mb-4">
                <input type="checkbox" name="terms" id="terms" required class="form-check-input">
                <label for="terms" class="form-check-label text-muted">
                    {!! __('Eu concordo com os :terms_of_service e :privacy_policy', [
                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-decoration-none text-primary">'.__('Termos de Serviço').'</a>',
                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-decoration-none text-primary">'.__('Política de Privacidade').'</a>',
                    ]) !!}
                </label>
            </div>
            @endif
            <div class="text-center mb-4">
                <p class="text-muted text-sm">Já tem uma conta? <a href="{{ route('login') }}" class="text-decoration-none text-primary">Faça login</a></p>
            </div>
            <div>
                <button type="submit" class="btn btn-dark btn-lg w-100">Registrar</button>
            </div>
        </form>
    </div>
</div>

@endsection
