@extends('layouts.bootstrap')

@section('title','Laravel: Formularios e Validações')

@section('content')

    <h3>Adicionar Cliente</h3>

    <h4>{{ $clientType == \App\Client::TYPE_INDIVIDUAL ? 'Pessoa Física' : 'Pessoa Jurídica'  }}</h4>

    <a href="{{ route('clients.create', ['client_type' => \App\Client::TYPE_INDIVIDUAL]) }}">Pessoa Física</a>
    <a href="{{ route('clients.create', ['client_type' => \App\Client::TYPE_LEGAL]) }}">Pessoa Jurídica</a>

    @include('form.form_errors') {{--Se houver erros--}}

    <form method="post" action="{{ route('clients.store') }}"> {{-- POST to resource /admin/clients/ --}}

        @include('admin.clients._form') {{-- Inclui campos comuns ao create/edit --}}

        <button type="submit" class="btn btn-default">Criar</button>

        <a class="btn btn-success" href="{{ route('clients.index') }}">Voltar</a>
    
    </form>

@endsection