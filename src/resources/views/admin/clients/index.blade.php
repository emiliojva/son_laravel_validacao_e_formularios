<!-- Stored in resources/views/layouts/bootstrap.blade.php -->
@extends('layouts.bootstrap')

<!-- $yield title value -->
@section('title','Formularios e Validações - Blade, trabalhando com templates')

<!-- $yield content value -->
@section('content')
    <h3>Listagem de clientes</h3>

    <a class="btn btn-default" href="{{ route('clients.create') }}">Criar</a>

    <br/><br/>

    <table border="1" class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CNPJ/CPF</th>
            <th>Data Nasc.</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Sexo</th>
            <th>Ação</th>
        </tr>
        </thead>
        <tbody>
        @foreach($clientsARCollection as $client)
            <tr>
                <td>{{ $client->id }}</td>
                <td>{{ $client->name }}</td>
                <td>{{ $client->document_number }}</td>
                <td>{{ $client->date_birth }}</td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->phone }}</td>
                <td>{{ $client->sex }}</td>
                <td>
                    <a href="{{ route( 'clients.edit', ['client' => $client->id] ) }}">editar</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection