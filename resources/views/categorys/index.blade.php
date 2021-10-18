@extends('layouts.app')
@section('title', 'teste')
@section('page-title', 'teste')
@section('content')
<table class="table table-hover" >
    <thead>
        <tr>
            <th>Descrição</th>
            <th>-</th>
        </tr>
    </thead>
    <tbory>
        @foreach($categorys as $category)
        <tr>
            <td>{{ $category->description}}</td>
            <td></td>
        </tr>
        @endforeach
    </tbory>
</table>
@endsection
