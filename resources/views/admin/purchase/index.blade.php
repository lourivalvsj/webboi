@extends('layouts.app')
@section('title', 'Gerenciamento de Compra')
@section('page-title', 'Gerenciamento de Compra')
@section('content')
    <a href="#" class="btn btn-success">Novo Compra</a>
    <table class="table table-hover">
        <thead>
        <tr>
            <th class="main-col">Compra</th>
            <th>-</th>
        </tr>
        </thead>
        <tbody>
        @foreach(categorys as $category)
            <tr>
                <td class="main-col">{{$category->description}}</td>
                <td>
                    <a href="#" class="btn btn-primary">Editar</a>
                   {{-- <form method="post" action="{{route('genres.destroy', $genre)}}" style="display: inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Excluir</button>
                    </form>
                    --}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
