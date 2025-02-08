@extends('includes.body')
@section('title', 'Definições de Conta')
@section('content')

<style>
    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
</style>

<div class="container my-5">
    <div class="row">
        <!-- Sidebar -->
        <aside class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h4 fw-bold text-center mb-4">Definições de Conta</h2>
                    <nav class="d-flex flex-column gap-2">
                        <button class="btn btn-outline-secondary text-start" data-bs-toggle="modal" data-bs-target="#personalInfoModal">
                            Informações Pessoais
                        </button>
                        <button class="btn btn-outline-secondary text-start" data-bs-toggle="modal" data-bs-target="#changeEmailModal">
                            Mudar Email
                        </button>
                        <button class="btn btn-outline-secondary text-start" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            Alterar Senha
                        </button>
                    </nav>
                </div>
            </div>
        </aside>

        <!-- Conteúdo Principal -->
        <main class="col-md-9">
            @if(session()->has('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Seção de Informações Pessoais -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center gap-3 mb-4">
                        <!-- Container da Imagem -->
                        <label for="profile-photo-input" class="cursor-pointer position-relative">
                            <img
                                id="profile-photo"
                                src="{{ auth()->user()->profile_photo_path ? asset('storage/' . auth()->user()->profile_photo_path) : asset('storage/avatar.png') }}"
                                alt="Avatar do usuário"
                                class="rounded-circle object-fit-cover"
                                style="width: 120px; height: 120px; border: 2px solid #dee2e6;"
                            >
                            <!-- Spinner de Loading -->
                            <div id="loading-spinner" class="position-absolute top-50 start-50 translate-middle" style="display: none;">
                                <div class="spinner-border text-success" role="status"></div>
                            </div>
                        </label>
                        <!-- Input para Carregar Imagem -->
                        <input type="file" id="profile-photo-input" accept="image/*" class="d-none">
                        <!-- Botões de Ação -->
                        <div id="action-buttons" class="d-none gap-2">
                            <button id="update-button" class="btn btn-success">Atualizar Imagem</button>
                            <button id="cancel-button" class="btn btn-danger">Cancelar</button>
                        </div>
                    </div>

                    <!-- Formulário de Informações Pessoais -->
                    <form action="/updateProfile" method="POST" class="d-flex flex-column gap-3">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-label fw-bold">Nome Completo</label>
                            <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="phone" class="form-label fw-bold">Telefone</label>
                            <input type="text" id="phone" name="phone" placeholder="Seu Telefone" value="{{ auth()->user()->phone }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="website" class="form-label fw-bold">Website</label>
                            <input type="text" id="website" name="website" placeholder="Site ou endereço digital" value="{{ auth()->user()->website }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="country" class="form-label fw-bold">País</label>
                            <input type="text" id="country" name="country" placeholder="País de Origem" value="{{ auth()->user()->country }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="city" class="form-label fw-bold">Cidade</label>
                            <input type="text" id="city" name="city" placeholder="Cidade em que mora" value="{{ auth()->user()->city }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="company" class="form-label fw-bold">Empresa</label>
                            <input type="text" id="company" name="company" placeholder="Nome da Empresa" value="{{ auth()->user()->company }}" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Modal para Mudar Email -->
<div class="modal fade" id="changeEmailModal" tabindex="-1" aria-labelledby="changeEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="changeEmailModalLabel">Mudar Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-4">Email atual: <b>{{ auth()->user()->email }}</b></p>
                <form action="/updateEmail" method="POST" class="d-flex flex-column gap-3">
                    @csrf
                    <div class="form-group">
                        <label for="new-email" class="form-label fw-bold">Novo Email</label>
                        <input type="email" id="new-email" name="new_email" required class="form-control @error('new_email') is-invalid @enderror">
                        @error('new_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="confirm-email" class="form-label fw-bold">Confirmar Novo Email</label>
                        <input type="email" id="confirm-email" name="confirm_email" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Alterar Senha -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="changePasswordModalLabel">Alterar Senha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/updatePassword" method="POST" class="d-flex flex-column gap-3">
                    @csrf
                    <div class="form-group">
                        <label for="new-password" class="form-label fw-bold">Nova Senha</label>
                        <input type="password" id="new-password" name="new_password" required class="form-control @error('new_password') is-invalid @enderror">
                        @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="confirm-password" class="form-label fw-bold">Confirmar Nova Senha</label>
                        <input type="password" id="confirm-password" name="confirm_password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const profilePhoto = document.getElementById('profile-photo');
    const profilePhotoInput = document.getElementById('profile-photo-input');
    const actionButtons = document.getElementById('action-buttons');
    const updateButton = document.getElementById('update-button');
    const cancelButton = document.getElementById('cancel-button');
    const loadingSpinner = document.getElementById('loading-spinner');

    profilePhoto.addEventListener('click', () => profilePhotoInput.click());
    profilePhotoInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            loadingSpinner.style.display = 'block';
            reader.onload = function (e) {
                profilePhoto.src = e.target.result;
                loadingSpinner.style.display = 'none';
                actionButtons.classList.remove('d-none');
                actionButtons.classList.add('d-flex');
            };
            reader.readAsDataURL(file);
        }
    });

    cancelButton.addEventListener('click', () => {
        profilePhoto.src = "{{ auth()->user()->profile_photo_path ? asset('storage/' . auth()->user()->profile_photo_path) : asset('storage/avatar.png') }}";
        actionButtons.classList.add('d-none');
        loadingSpinner.style.display = 'none';
        profilePhotoInput.value = '';
    });

    updateButton.addEventListener('click', () => {
        const formData = new FormData();
        formData.append('profile_image', profilePhotoInput.files[0]);
        loadingSpinner.style.display = 'block';

        fetch('/profile/update-photo', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: formData
        })
        .then(response => {
            if (response.ok) {
                alert('Imagem atualizada com sucesso!');
                actionButtons.classList.add('d-none');
            }
            loadingSpinner.style.display = 'none';
        })
        .catch(error => {
            console.error('Erro:', error);
            loadingSpinner.style.display = 'none';
        });
    });
</script>

@endsection