@extends('layouts.admin')

@section('content')
    <div class="content-title">
        <h1 class="page-title">Registar Utilizador</h1>
        <a href="{{ route('user.index') }}" class="btn-primary">Listar</a>
    </div>

    <x-alert/>

    <form action="{{ route('user.store') }}" method="POST" class="form-container">
        @csrf

        <div class="mb-4">
            <label for="name" class="form-label">Nome:</label>
            <input type="text" name="name" id="name" class="form-input"
                   placeholder="Nome completo do utilizador" value="{{ old('name') }}">
        </div>

        <div class="mb-4">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" name="email" id="email" class="form-input"
                   placeholder="E-mail do utilizador" value="{{ old('email') }}">
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" id="password" class="form-input"
                   placeholder="Password com mínimo de 8 caracteres">
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirmação Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-input"
                   placeholder="Confirmar password">
        </div>

        <button type="submit" class="btn-success">Registar</button>
    </form>
@endsection
