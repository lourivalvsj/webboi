@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Pesagens</h2>
            <a href="{{ route('animal-weights.create') }}" class="btn btn-primary">Nova Pesagem</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Animal</th>
                    <th>Peso (kg)</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($weights as $weight)
                    <tr>
                        <td>{{ $weight->animal->tag ?? '-' }}</td>
                        <td>{{ number_format($weight->weight, 2, ',', '.') }}</td>
                        <td>{{ $weight->recorded_at }}</td>
                        <td>
                            <a href="{{ route('animal-weights.edit', $weight) }}" class="btn btn-warning btn-sm">Editar</a>

                            <form action="{{ route('animal-weights.destroy', $weight) }}" method="POST"
                                style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Tem certeza que deseja excluir esta pesagem?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Nenhum registro encontrado...</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
