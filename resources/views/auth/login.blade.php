@extends('includes.body')
@section('title', 'Login')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@section('content')

    <div class="d-flex justify-content-center align-items-center m-4">
        <div class="shadow p-4 rounded" style="width: 100%; max-width: 500px;">
            <div class="text-center mb-6 ">
                <h2 class="text-2xl font-semibold text-gray-800">Entrar</h2>
                <p class="text-gray-600">Por favor, preencha os campos abaixo para poder entrar.</p>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Input -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Digite seu email" required autofocus>
                </div>

                <!-- Password Input -->
                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Digite sua senha" required>
                </div>

                <!-- Forgot Password -->
                <div class="mb-3 text-end">
                    <a href="{{ route('password.request') }}" class="text-decoration-none">Esqueceu sua senha?</a>
                </div>

                <!-- Submit Button -->
                <div class="mb-4">
                    <button type="submit" class="btn btn-dark btn-lg w-100">Entrar</button>
                </div>
            </form>

            <!-- Divider -->
            <div class="text-center my-3">
                <hr>
                <span class="position-relative bg-white px-3" style="top: -12px;">Ou</span>
            </div>

            <!-- Register Link -->
            <div class="text-center">
                <p class="mb-0">Ainda não tem uma conta? <a href="/register" class="text-decoration-none">Registe-se</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
