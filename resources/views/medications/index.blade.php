@extends('layouts.app')
@section('title', 'Medicações')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Medicações</h2>
            <a href="{{ route('medications.create') }}" class="btn btn-primary">Nova Medicação</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Animal</th>
                    <th>Medicamento</th>
                    <th>Dosagem</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($medications as $medication)
                    <tr>
                        <td>{{ $medication->animal->tag }}</td>
                        <td>{{ $medication->medication_name }}</td>
                        <td>{{ $medication->dose }}</td>
                        <td>{{ $medication->administration_date }}</td>
                        <td>
                            <a href="{{ route('medications.edit', $medication) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('medications.destroy', $medication) }}" method="POST"
                                style="display:inline-block">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
