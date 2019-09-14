@extends('layouts.bootstrap')

@section('title','Laravel: Formularios e Validações')

@section('content')

    <h3>Editar Cliente</h3>

    {{--Se houver erros--}}
    @if ($errors->any())

        <ul class="alert alert-danger">

            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach

        </ul>

    @endif

    {{--Formulario de Edicao--}}
    <form method="post" action="{{ route('clients.update' , $clientsAR->id) }}">

        {{-- Validation Field Protection. required to submit post --}}
        {{csrf_field()}}

        <input type="hidden" name="client_type" value="">

        <div class="form-group">
            <label for="name">Nome</label>
            <input class="form-control" id="name" name="name" value="{{ $clientsAR->name }}">
        </div>

        <div class="form-group">
            <label for="document_number">Documento</label>
            <input class="form-control" id="document_number" name="document_number"
                value="{{ $clientsAR->document_number }}">
        </div>

        <div class="form-group">
            <label for="email">E-mail</label>
            <input class="form-control" id="email" name="email" type="email"
                   value="{{ $clientsAR->email }}">
        </div>

        <div class="form-group">
            <label for="phone">Telefone</label>
            <input class="form-control" id="phone" name="phone"
                   value="{{ $clientsAR->phone }}">
        </div>

        <div class="form-group">
            <label for="marital_status">Estado Civil</label>
            <select class="form-control" name="marital_status" id="marital_status"
                    value="{{ $clientsAR->marital_status }}">
                <option value="">Selecione o estado civil</option>
                @foreach( \App\Client::MARITAL_STATUS as $key=>$status )
                    <option value="{{ $key }}" {{ $key == $clientsAR->marital_status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="date_birth">Data Nasc.</label>
            <input class="form-control" id="date_birth" name="date_birth" type="date"
                   value="{{ $clientsAR->date_birth }}">
        </div>

        <div class="radio">
            <label>
                <input type="radio" name="sex" value="m"
                       {{ $clientsAR->sex == 'm' ? 'checked="true" ' : '' }} >
                Masculino
            </label>
        </div>

        <div class="radio">
            <label>
                <input type="radio" name="sex" value="f"
                        {{ $clientsAR->sex == 'f' ? 'checked="true" ' : '' }} >
                Feminino
            </label>
        </div>

        <div class="form-group">
            <label for="physical_disability">Deficiência Física</label>
            <input class="form-control" id="physical_disability" name="physical_disability"
                value="">
        </div>
       
        <div class="checkbox">
            <label>
                <input id="defaulter" name="defaulter" type="checkbox"
                        {{ $clientsAR->defaulter == 1 ? 'checked="true" ' : '' }} >
                Inadimplente?
            </label>
        </div>

        <button type="submit" class="btn btn-default">Salvar</button>

        <a class="btn btn-success" href="{{ route('clients.index') }}">Voltar</a>
    
    </form>
@endsection



<script>
    window.onload = function(){

        document.getElementById('marital_status').value = "{{ $clientsAR->marital_status  }}"

    }
</script>