@extends('layouts.bootstrap')

@section('title','Laravel: Formularios e Validações')

@section('content')

    <h3>Editar Cliente</h3>

    @include('form.form_errors') {{--Se houver erros--}}

    {{--Formulario de Edicao--}}
    <form method="post" action="{{ route('clients.update' , $clientsAR->id) }}">

        {{  method_field('put') }} {{-- <input type="hidden" name="_method" value="put"> --}} {{-- Associar verbo HTTP PUT com input hidden OU method_field('PUT') --}} {{-- Equivalent method_field('put') --}}

        @include('admin.clients._form') {{--Inclui formulario padrao para create/edit--}}

        <button type="submit" class="btn btn-default">Salvar</button>

        <a class="btn btn-success" href="{{ route('clients.index') }}">Voltar</a>
    
    </form>

@endsection