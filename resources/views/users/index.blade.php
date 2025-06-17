@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="content-title">
            <h1 class="page-title">Listar os Utilizadores</h1>
            <span>
                <a href="{{ route('user.create') }}" class="btn-success">Registar</a>
                <a href="{{ url('generate-pdf-user') . (request()->getQueryString() ? '?' . request()->getQueryString() : '') }}" class="btn-warning">Gerar PDF</a>

{{--                <a href="{{ url('generate-csv-user') . (request()->getQueryString() ? '?' . request()->getQueryString() : '')  }}" class="btn-success">Gerar CSV</a>--}}
            </span>
        </div>

        <x-alert />

{{--        <form class="pb-3 grid md:grid-cols-2 gap-2 items-end" action="#" method="POST" enctype="multipart/form-data">--}}
{{--            @csrf--}}

{{--            <label class="form-input cursor-pointer flex items-center justify-center bg-white text-gray-700 hover:bg-blue-50">--}}
{{--                <input type="file" name="file" id="file" accept=".csv">--}}
{{--            </label>--}}

{{--            <button type="submit" class="btn-success">Importar CSV</button>--}}
{{--        </form>--}}

        <form class="pb-3 grid xl:grid-cols-5 md:grid-cols-2 gap-2 items-end">

            <input type="text" name="name" class="form-input" placeholder="Digite o nome" value="">

            <input type="text" name="email" class="form-input" placeholder="Digite o e-mail" value="">

            <input type="datetime-local" name="start_date_registration" class="form-input" value="">

            <input type="datetime-local" name="end_date_registration" class="form-input" value="">

            <div class="flex gap-1">
                <button type="submit" class="btn-primary">
                    <span>Pesquisar</span>
                </button>
                <a href="{{ route('user.index') }}" class="btn-warning">
                    <span>Limpar</span>
                </a>
            </div>

        </form>

        <div class="table-container">
            <table class="table">
                <thead>
                <tr class="table-header">
                    <th class="table-header">ID</th>
                    <th class="table-header">Nome</th>
                    <th class="table-header">Role</th>
                    <th class="table-header">E-mail</th>
                    <th class="table-header center">Ações</th>
                </tr>
                </thead>
                <tbody class="table-body">
                @forelse ($users as $user)
                    <tr class="table-row">
                        <td class="table-cell">{{ $user->id }}</td>
                        <td class="table-cell">{{ $user->name }}</td>
                        <td class="table-cell">{{ $user->role }}</td>
                        <td class="table-cell">{{ $user->email }}</td>
                        <td class="table-actions">
                            <a href="{{ route('user.show', ['user' => $user->id]) }}" class="btn-primary">Visualizar</a>

                            @can('update',$user)
                                <a href="{{ route('user.edit', ['user' => $user->id]) }}" class="btn-warning">Editar</a>
                            @endcan

                            @can('delete',$user)
                                <form id="delete-form-{{ $user->id }}"
                                      action="{{ route('user.destroy', ['user' => $user->id]) }}"
                                      method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="button" class="btn-danger" onclick="confirmdDelete({{ $user->id }})">Apagar</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <div class="alert-error">
                        Nenhum usuário encontrado!
                    </div>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $users->links() }}
        </div>
    </div>
@endsection
