@extends('layouts.bootstrap')

@section('title','Formularios e Validações - Mass Assisnment e Criação de Clientes')

@section('content')
    <form method="post" action="/admin/clients/">

        {{csrf_field()}}

        <input type="hidden" name="client_type" value="">
        <div class="form-group">
            <label for="name">Nome</label>
            <input class="form-control" id="name" name="name" value="">
        </div>

        <div class="form-group">
            <label for="document_number">Documento</label>
            <input class="form-control" id="document_number" name="document_number"
                value="">
        </div>

        <div class="form-group">
            <label for="email">E-mail</label>
            <input class="form-control" id="email" name="email" type="email" value="">
        </div>

        <div class="form-group">
            <label for="phone">Telefone</label>
            <input class="form-control" id="phone" name="phone" value="">
        </div>

        <div class="form-group">
            <label for="marital_status">Estado Civil</label>
            <select class="form-control" name="marital_status" id="marital_status" value="">
                <option value="">Selecione o estado civil</option>
                <option value="1" >Solteiro</option>
                <option value="2" >Casado</option>
                <option value="3" >Divorciado</option>
            </select>
        </div>
        <div class="form-group">

        <label for="date_birth">Data Nasc.</label>
            <input class="form-control" id="date_birth" name="date_birth" type="date"
                value="">
        </div>

        <div class="radio">
            <label>
                <input type="radio" name="sex" value="m" > Masculino
            </label>
        </div>

        <div class="radio">
            <label>
                <input type="radio" name="sex" value="f"> Feminino
            </label>
        </div>

        <div class="form-group">
            <label for="physical_disability">Deficiência Física</label>
            <input class="form-control" id="physical_disability" name="physical_disability"
                value="">
        </div>
       
        <div class="checkbox">
            <label>
                <input id="defaulter" name="defaulter" type="checkbox">
                Inadimplente?
            </label>
        </div>

        <button type="submit" class="btn btn-default">Criar</button>
    
    </form>
@endsection