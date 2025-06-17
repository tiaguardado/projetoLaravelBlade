@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="mb-4">Minha Lista de Tarefas</h1>

        {{-- Formulário para adicionar nova tarefa --}}
        <form action="{{ route('tasks.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="input-group">
                <input type="text" name="title" class="form-control" placeholder="Nova tarefa" required>
                <button class="btn btn-primary" type="submit">Adicionar</button>
            </div>
        </form>

        <x-alert />

        {{-- Lista de tarefas --}}
        <ul class="list-group">
            @forelse($tasks as $task)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <form action="{{ route('tasks.toggle', $task) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-sm {{ $task->completed ? 'btn-success' : 'btn-outline-secondary' }}">
                                {{ $task->completed ? '✔' : '⏺' }}
                            </button>
                        </form>

                        <span class="{{ $task->completed ? 'text-decoration-line-through text-muted' : '' }}">
                        {{ $task->title }}
                    </span>
                    </div>

                    <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Apagar</button>
                    </form>
                </li>
            @empty
                <li class="list-group-item">Nenhuma tarefa ainda.</li>
            @endforelse
        </ul>
    </div>
@endsection
