@extends('includes.body')
@section('title', 'Login')
@section('content')

<div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="shadow-lg p-5 rounded" style="width: 100%; max-width: 450px;">
        <div class="text-center mb-4">
            <h2 class="h3 font-weight-bold text-dark">Entrar</h2>
            <p class="text-muted">Por favor, preencha os campos abaixo para acessar sua conta.</p>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="list-unstyled mb-0">
                   Credenciais incorrectas
                </ul>
            </div>
            
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Digite seu email" required autofocus>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Senha</label>
                <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Digite sua senha" required>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="{{ route('password.request') }}" class="text-decoration-none text-muted">Esqueceu sua senha?</a>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-dark btn-lg w-100">Entrar</button>
            </div>
        </form>
        <div class="text-center my-3">
            <hr>
            <span class="position-relative bg-white px-3" style="top: -12px;">Ou</span>
        </div>
        <div class="text-center">
            <p class="mb-0">Ainda não tem uma conta? <a href="/register" class="text-decoration-none">Registre-se</a></p>
        </div>
    </div>
</div>

@endsection
