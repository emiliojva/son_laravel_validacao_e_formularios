@php

    /*Consumir apenas uma vez persistencia no model*/

    $marital_status = $client->marital_status; // estado civil

    $sex = $client->sex; // genero

   // $defaulter = $client->defaulter; // inadimplente

    $defaulter = $client->defaulter;

@endphp

{{-- Validation Field Protection. required to submit post --}}
{{csrf_field()}}

<input type="hidden" name="client_type" value="">

<div class="form-group">
    <label for="name">Nome</label>
    <input class="form-control" id="name" name="name" value="{{ old('name',$client->name) }}">
</div>

<div class="form-group">
    <label for="document_number">Documento</label>
    <input class="form-control" id="document_number" name="document_number"
           value="{{ old('document_number',$client->document_number) }}">
</div>

<div class="form-group">
    <label for="email">E-mail</label>
    <input class="form-control" id="email" name="email" type="email"
           value="{{ old('email',$client->email) }}">
</div>

<div class="form-group">
    <label for="phone">Telefone</label>
    <input class="form-control" id="phone" name="phone"
           value="{{ old('phone',$client->phone) }}">
</div>

<div class="form-group">
    <label for="marital_status">Estado Civil</label>
    <select class="form-control" name="marital_status" id="marital_status"
            value="{{ old('marital_status',$marital_status) }}">
        <option value="">Selecione o estado civil</option>
        @foreach( \App\Client::MARITAL_STATUS as $key=>$status )
            <option value="{{ $key }}" {{ $key == old('marital_status',$marital_status) ? 'selected' : '' }}>{{ $status }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="date_birth">Data Nasc.</label>
    <input class="form-control" id="date_birth" name="date_birth" type="date"
           value="{{ old('date_birth',$client->date_birth) }}">
</div>

<div class="radio">
    <label>
        <input type="radio" name="sex" value="m"
                {{ old('sex',$sex) == 'm' ? 'checked="true" ' : '' }} >
        Masculino
    </label>
</div>

<div class="radio">
    <label>
        <input type="radio" name="sex" value="f"
                {{ old('sex',$sex) == 'f' ? 'checked="true" ' : '' }} />
        Feminino
    </label>
</div>

<div class="form-group">
    <label for="physical_disability">Deficiência Física</label>
    <input class="form-control" id="physical_disability" name="physical_disability"
           value="{{ old('physical_disability',$client->physical_disability) }}" />
</div>

<div class="checkbox">
    <label>
        <input id="defaulter" name="defaulter" type="checkbox" {{ old('defaulter',$defaulter)  ? ' checked=checked' : '' }} />
        Inadimplente?
    </label>
</div>