@extends('layouts.login')

@section('content')
    <h1 class="title-login">Área Restrita</h1>

    <x-alert />

    <form class="mt-4" action="{{ route('login.process') }}" method="POST">
        @csrf
        @method('POST')

        <div class="form-group-login">
            <label for="email" class="form-label-login">E-mail</label>
            <input type="email" name="email" id="email" placeholder="Digite o e-mail de utlizador"
                   class="form-input-login" value="{{ old('email') }}" required>
        </div>

        <div class="form-group-login">
            <label for="password" class="form-label-login">Senha</label>
            <input type="password" name="password" id="password" placeholder="Digite a senha de utlizador"
                   class="form-input-login" value="{{ old('password') }}" required>
        </div>

        <!-- Link para recuperação de senha e botão de login -->
        <div class="btn-group-login">
            <a href="{{ route('password.request') }}" class="link-login">Esqueceu a senha?</a>
            <button type="submit" class="btn-primary-md">Login</button>
        </div>

        <div class="mt-4 text-center">
            <a href="#" class="link-login">Criar nova conta!</a>
        </div>
    </form>
@endsection

