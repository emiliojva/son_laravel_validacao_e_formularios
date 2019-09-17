<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \App\Client as Client;
use Illuminate\Support\Facades\App;

class ClientsController extends Controller // controller resource
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // echo "Index ou Listing";

        $clientsARCollection = \App\Client::all();

        return view('admin.clients.index', compact(['clientsARCollection']));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = new Client();

        $client->defaulter = 0;

        // echo "GET - Form to Creates one registry";
        return view('admin.clients.create' , compact('client'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // validando entrada do formulario
        $this->_validate($request);

        //  echo "POST - Storing Form data Post";
        // dump($request->all());
        $data = $request->all();
        $data['defaulter'] = $request->has('defaulter'); // inadimplente
        Client::create($data);

        return redirect()->route('clients.index'); //return redirect()->route('/admin/clients');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
//        echo "GET - Displaying one registry";
        return view('admin.clients.show' , compact(['client']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        // echo "GET - Form loads id {$id} to Update one registry";
        /**
         * @global $client \Illuminate\Database\Eloquent\Model
         */
//        $client = Client::findOrFail($client); // O metodo findOrFail ja retorna uma excecao para uma pagina 404

        return view('admin.clients.edit', compact( ['client'] ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        // echo "PUT - Updating Form data Post";

        /**
         * @global $clientsAR \Illuminate\Database\Eloquent\Model
         */
//        $clientsAR = Client::findOrFail($id); // O metodo findOrFail ja retorna uma excecao para uma pagina 404

        // validando entrada do formulario
        $this->_validate($request);

        // se passar a validacao pego request sabendo que o preechimento será por conta do $fillable
        $data = $request->all();

        $data['defaulter'] = $request->has('defaulter'); // inadimplente

        $client->fill($data);

        $client->save();

        return redirect()->route('clients.index'); // OR redirect()->route('/admin/clients');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
        echo "DELETE - Updating Form data Post";
    }

    protected function _validate(Request $request)
    {
        $maritalStatus = implode( ',' , array_keys(Client::MARITAL_STATUS) );

        // Metodo de Validação do laravel. Se nao atender, retorna para mesma página
        $this->validate($request, [
            'name'=>'required|max:255', // obrigatorio e no max 255 chars
            'document_number'=> 'required',
            'email'=>'required|email',
            'phone'=>'required',
            'date_birth'=>'required|date',
            'marital_status'=>"required|in:{$maritalStatus}",
            'sex'=>'required|in:m,f',
            'physical_desability'=>'max:255'
        ]);

    }
}