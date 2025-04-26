@extends('layouts.app')

@section('title', 'Animais')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Animais</h2>
            <a href="{{ route('animals.create') }}" class="btn btn-primary">Adicionar Novo</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Brinco</th>
                    <th>Raça</th>
                    <th>Data de Nascimento</th>
                    <th>Peso Inicial</th>
                    <th>Categoria</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($animals as $animal)
                    <tr>
                        <td>{{ $animal->id }}</td>
                        <td>{{ $animal->tag }}</td>
                        <td>{{ $animal->breed }}</td>
                        <td>{{ $animal->birth_date }}</td>
                        <td>{{ $animal->initial_weight }}</td>
                        <td>{{ $animal->category->name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('animals.edit', $animal) }}" class="btn btn-sm btn-warning">Editar</a>

                            <form action="{{ route('animals.destroy', $animal) }}" method="POST"
                                style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Deseja excluir este animal?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Nenhum animal encontrado...</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
