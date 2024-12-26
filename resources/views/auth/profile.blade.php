@extends('includes.body')
@section('title', 'Definições de Conta')
@section('content')

<div style="display: flex; height: 100vh;">

    <!-- Menu lateral -->
    <aside style="width: 25%; background-color: #EEEEEE; padding: 20px; border-right: 1px solid #CCC;">
        <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 20px; text-align: center;">Definições de Conta</h2>
        <nav style="display: flex; flex-direction: column; gap: 12px;">
            <button
                onclick="selectMenuItem(this, 'personal-info')"
                style="padding: 12px; background-color: #EEEEEE; border: none; color: #333; font-size: 1rem; text-align: left; cursor: pointer; border-radius: 4px;">
                Informações Pessoais
            </button>
            <button
                onclick="selectMenuItem(this, 'change-email')"
                style="padding: 12px; background-color: #EEEEEE; border: none; color: #333; font-size: 1rem; text-align: left; cursor: pointer; border-radius: 4px;">
                Mudar Email
            </button>
            <button
                onclick="selectMenuItem(this, 'change-password')"
                style="padding: 12px; background-color: #EEEEEE; border: none; color: #333; font-size: 1rem; text-align: left; cursor: pointer; border-radius: 4px;">
                Alterar Senha
            </button>
        </nav>
    </aside>

    <!-- Conteúdo -->
    <main id="content-section" style="width: 75%; padding: 40px; overflow-y: auto;">
        @if(session()->has('status'))
        <div class="alert alert-success" style="background-color: #DFF0D8; color: #3E8E41; border: 1px solid #C6E2B5; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
            {{ session('status') }}
        </div>
    @endif
        <!-- Por padrão, renderiza as Informações Pessoais -->
        <section id="personal-info" style="display: block; overflow-y: hidden;">
            <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 20px;">Informações Pessoais</h2>
            <div style="display: flex; justify-content: center;">
                <img
                src="{{ auth()->user()->profile_photo_path ? asset('storage/' . auth()->user()->profile_photo_path) : asset('storage/avatar.png') }}"
                alt="Avatar do usuário"
                style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 2px solid #CCC;">
            </div>
            <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 20px;">
                <form action="/updateProfile" method="POST" style="width: 100%; display: flex; flex-direction: column; gap: 16px;">
                    @csrf
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <label for="name" style="font-size: 1rem; font-weight: bold;">Nome Completo</label>
                        <input type="text" id="name" name="name" value="{{ auth()->user()->name }}"
                            style="padding: 8px; border: 1px solid #CCC; border-radius: 4px; font-size: 1rem;">
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <label for="phone" style="font-size: 1rem; font-weight: bold;">Telefone</label>
                        <input type="text" id="phone" name="phone" placeholder="Seu Telefone" value="{{auth()->user()->phone ? auth()->user()->phone : '' }}"
                            style="padding: 8px; border: 1px solid #CCC; border-radius: 4px; font-size: 1rem;">
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <label for="phone" style="font-size: 1rem; font-weight: bold;">website</label>
                        <input type="text" id="phone" name="website" placeholder="Site ou endereço digital" value="{{auth()->user()->website ? auth()->user()->website : '' }}"
                            style="padding: 8px; border: 1px solid #CCC; border-radius: 4px; font-size: 1rem;">
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <label for="phone" style="font-size: 1rem; font-weight: bold;">País</label>
                        <input type="text" id="phone" name="contry" placeholder="País de Origem" value="{{auth()->user()->contry ? auth()->user()->contry : ''}}"
                            style="padding: 8px; border: 1px solid #CCC; border-radius: 4px; font-size: 1rem;">
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <label for="phone" style="font-size: 1rem; font-weight: bold;">Cidade</label>
                        <input type="text" id="phone" name="city" placeholder="Cidade em que mora" value="{{auth()->user()->city ? auth()->user()->city : ''}}"
                            style="padding: 8px; border: 1px solid #CCC; border-radius: 4px; font-size: 1rem;">
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <label for="phone" style="font-size: 1rem; font-weight: bold;">Empresa</label>
                        <input type="text" id="phone" name="company" placeholder="Nome da Empresa" value="{{auth()->user()->company ? auth()->user()->company : ''}}"
                            style="padding: 8px; border: 1px solid #CCC; border-radius: 4px; font-size: 1rem;">
                    </div>
                    <button type="submit"
                        style="padding: 10px; background-color: #333; color: white; border: none; border-radius: 8px; font-size: 1rem; cursor: pointer;">
                        Salvar
                    </button>
                </form>
            </div>
        </section>

        <section id="change-email" style="display: none;">
            <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 20px;">Mudar Email</h2>
            <p style="margin-bottom: 20px; font-size: 1rem;">Email atual: <b>{{auth()->user()->email}}</b></p>
            <form action="/updateEmail" method="POST" style="width: 100%; display: flex; flex-direction: column; gap: 16px;">
                @csrf
                <div style="display: flex; flex-direction: column; gap: 4px;">
                    <label for="new-email" style="font-size: 1rem; font-weight: bold;">Novo Email</label>
                    <input type="email" id="new_email" name="new_email" required @error('new_email') is-invalid @enderror
                        style="padding: 8px; border: 1px solid #CCC; border-radius: 4px; font-size: 1rem;">
                        @error('new_email')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div style="display: flex; flex-direction: column; gap: 4px;">
                    <label for="confirm-email" style="font-size: 1rem; font-weight: bold;">Confirmar Novo Email</label>
                    <input type="email" id="confirm_email" name="confirm_email"
                        style="padding: 8px; border: 1px solid #CCC; border-radius: 4px; font-size: 1rem;">
                </div>
                <button type="submit"
                    style="padding: 10px; background-color: #333; color: white; border: none; border-radius: 8px; font-size: 1rem; cursor: pointer;">
                    Salvar
                </button>
            </form>
        </section>

        <section id="change-password" style="display: none;">
            <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 20px;">Alterar Senha</h2>
            <form action="/updatePassword" method="POST" style="width: 100%; display: flex; flex-direction: column; gap: 16px;">
                @csrf
                <div style="display: flex; flex-direction: column; gap: 4px;">
                    <label for="new-password" style="font-size: 1rem; font-weight: bold;">Nova Senha</label>
                    <input type="password" id="new-password" name="new_password" placeholder="Nova Senha" required @error('new_password') is-invalid @enderror
                    style="padding: 8px; border: 1px solid #CCC; border-radius: 4px; font-size: 1rem;">
                    @error('new_password')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div style="display: flex; flex-direction: column; gap: 4px;">
                    <label for="confirm-password" style="font-size: 1rem; font-weight: bold;">Confirmar Nova Senha</label>
                    <input type="password" id="confirm-password" placeholder="Confirmar senha" name="confirm_password"
                        style="padding: 8px; border: 1px solid #CCC; border-radius: 4px; font-size: 1rem;">
                </div>
                <button type="submit"
                    style="padding: 10px; background-color: #333; color: white; border: none; border-radius: 8px; font-size: 1rem; cursor: pointer;">
                    Salvar
                </button>
            </form>
        </section>
    </main>
</div>

<script>
    function selectMenuItem(button, sectionId) {
        // Reset all buttons
        document.querySelectorAll('aside button').forEach(btn => {
            btn.style.backgroundColor = '#EEEEEE';
        });
        // Highlight the selected button
        button.style.backgroundColor = '#FFFFFF';

        // Render the selected section
        document.querySelectorAll('main section').forEach(section => {
            section.style.display = section.id === sectionId ? 'block' : 'none';
        });
    }
</script>

@endsection