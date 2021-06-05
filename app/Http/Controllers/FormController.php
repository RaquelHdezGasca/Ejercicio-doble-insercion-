<?php

namespace App\Http\Controllers;

use App\Models\Tb_Mensaje;
use Illuminate\Http\Request;
use App\Models\TbMensaje;
use Illuminate\Support\Facades\DB;
use Iluminate\View\View;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $Prueba = TbMensaje::get();
        //return $Prueba;
        return view('home', compact('Prueba'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       /* $Answer = TbMensaje::create([
            'name' => request('name'),
            'lastname' => request('lastname'),
        ]);
        $Answerpg = Tb_Mensaje::create([
            'name' => request('name'),
            'lastname' => request('lastname')
        ]);*/

        //Relacionar las conexiones de pgsql y mysql a sus respectivos modelos
       $connMysql = new TbMensaje;
       $connMysql->setConnection('mysql');

       $connPgsql = new Tb_Mensaje;
       $connPgsql->setConnection('pgsql');

       //Asignar el atributo name de cada modelo al request

      // $connMysql->name = $request('name');
      // $connPgsql->name = $request('name');

       $connMysql->name = $request->input('name');
       $connPgsql->name = $request->input('name');

        //Asignar el atributo lastname de cada modelo al request

       // $connMysql->lastname = $request('lastname');
        //$connPgsql->lastname = $request('lastname');

        $connMysql->lastname = $request->input('lastname');
        $connPgsql->lastname = $request->input('lastname');

        //Guardar los datos

        $connMysql->save();
        $connPgsql->save();

        
        $renglonMysql = TbMensaje::latest('id')->first(); //retorna el ultimo objeto TbMensaje de mysql
        $renglonPgsql = Tb_Mensaje::latest('id')->first(); //retorna el ultimo objeto Tb_Mensaje de pgsql

        //asi accedo a la propiedad id del objeto TbMensaje
        $idmysql = $renglonMysql->id;
        $idpgsql = $renglonPgsql->id;

       return back()->with('status', 'Nombre registrado en mysql con id: '.$idmysql.' y en postgresql con id: '.$idpgsql);
        
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //$id = request('id');
        return view('consult');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){

         //Relacionar las conexiones de pgsql y mysql a sus respectivos modelos
         $connMysql = new TbMensaje;
         $connMysql->setConnection('mysql');
  
         //$connPgsql = new Tb_Mensaje;
         //$connPgsql->setConnection('pgsql');

        $id = $request->input('id');
       // $name = DB::table('tb_mensaje')->where('id', $id)->value('name');//---------------****************
        
         //Consulta Pgsql
         //$namePG = Tb_Mensaje::get()->where('id', $id)->value('name');
         //$mesaagePG = Tb_Mensaje::get()->where('id', $id)->value('desc_mensaje');

         //Consulta Mysql
         //$nameMY = TbMensaje::get()->where('id', $id)->value('name');// Method Illuminate\Database\Eloquent\Collection::value does not exist.
         //$mesaageMY = TbMensaje::get()->where('id', $id)->value('desc_mensaje');

         //Tambien salio xd
         //$nameMY = TbMensaje::where("id","=", $id)->select('name')->get(); //El objeto de la clase Illuminate \ Database \ Eloquent \ Builder no se pudo convertir a una cadena
         //Si salió
         $nameMY = TbMensaje::select('name')->whereid($id)->get();//El objeto de la clase Illuminate \ Database \ Eloquent \ Builder no se pudo convertir a una cadena
         //$mesaageMY = TbMensaje::where("id","=", $id)->select('desc_mensaje');



        //$message = DB::table('tb_mensaje')->where('id', $id)->value('desc_mensaje');
        //return back()->with('status', $name.', '.$message);
        //return back()->with('status', 'Hola: '.$id);

         return back()->with('status', 'HolaMY: '.$nameMY);

         //return back()->with('status','HolaPG:'.$namePG);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
