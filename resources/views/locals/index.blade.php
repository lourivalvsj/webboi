@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Locais</h2>
            <a href="{{ route('locals.create') }}" class="btn btn-primary">Novo</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Entrada</th>
                    <th>Saída</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($locals as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->entry_date ?? '-' }}</td>
                        <td>{{ $item->exit_date ?? '-' }}</td>
                        <td>
                            <a href="{{ route('locals.edit', $item) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('locals.destroy', $item) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Confirmar exclusão?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
