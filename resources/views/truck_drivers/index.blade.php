@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Caminhoneiros</h2>
            <a href="{{ route('truck-drivers.create') }}" class="btn btn-primary">Novo</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Caminhão</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($truckDrivers as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->truck_description }}</td>
                        <td>
                            <a href="{{ route('truck-drivers.edit', $item) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('truck-drivers.destroy', $item) }}" method="POST"
                                style="display:inline-block;">
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
