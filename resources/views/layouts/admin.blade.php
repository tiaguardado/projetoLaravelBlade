<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>LaraHelps</title>
</head>
<body>
<div class="main-container">
    <header class="header">
        <div class="content-header">
            <h2 class="title-logo"><a href="{{ route('dashboard') }}">LaraHelps</a></h2>
            <ul class="list-nav-link">

                @can('viewAny', App\Models\User::class)
                    <li>
                        <a href="{{ route('user.index') }}" class="nav-link">Utilizadores</a>
                    </li>
                @endcan
                <li>
                    <a href="{{ route('user.show', ['user' => Auth::user()->id]) }}" class="nav-link">
                        {{ Auth::user()->name }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('tasks.index') }}" class="nav-link">To do</a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" class="nav-link">Sair</a>
                </li>
            </ul>
        </div>
    </header>

    <div class="content">
        @yield('content')
    </div>
</div>
</body>
</html>
