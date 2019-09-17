<!doctype html>
<html lang="{{ app()->getLocale() }}">

    <head>
    
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="/css/app.css">

        <!-- Styles -->
        <style>body{overflow-x: hidden;}</style>

    </head>

    <body>

        <div class="container">
            {{--Pega a rota nomeada atual--}}
            @php $route_name = Route::current()->action['as']; @endphp

            @component('layouts.navbar',['route_name'=>$route_name])

                @if(in_array($route_name,['clients.show']) )
                    <li><a class="btn " href="{{ route('clients.edit',['client' => $client->id]) }}">Editar</a></li>
                @endif

                @if(in_array($route_name,['clients.index','clients.show']) )
                    <li><a class="btn" href="{{ route('clients.create') }}">Criar</a></li>
                @endif

            @endcomponent
        </div>

        <div class="row">

            <div class="container">

                {{--<h1>@yield('title')</h1>--}}

                @yield('content')

            </div>

        </div>

        <script src="/js/app.js"></script>

    </body>

</html>
