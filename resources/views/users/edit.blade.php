@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="content-title">
            <h1 class="page-title">Editar Utilizador</h1>
            <span>
                <a href="{{ route('user.index') }}" class="btn-info">Listar</a>
                <a href="{{ route('user.show', ['user' => $user->id]) }}" class="btn-primary">Visualizar</a>
            </span>
        </div>

        <x-alert />

        <form action="{{ route('user.update', ['user' => $user->id]) }}" method="POST" class="form-container">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="form-label">Nome:</label>
                <input type="text" name="name" id="name" class="form-input"
                       placeholder="Nome completo do usuário" value="{{ old('name', $user->name) }}">
            </div>

            <div class="mb-4">
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" name="email" id="email" class="form-input"
                       placeholder="Melhor e-mail do usuário" value="{{ old('email', $user->email) }}">
            </div>


            @php
                $roles = ['super-admin', 'admin', 'user'];
            @endphp

            <div class="mb-4">
                <label for="role" class="form-label">Função:</label>
                <select name="role" id="role" class="form-input">
                    @foreach ($roles as $role)
                        <option value="{{ $role }}" {{ old('role', $user->role) == $role ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-warning">Salvar</button>
        </form>
    </div>
@endsection
