<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* Crear el usuario - primero se valida y despues se procede a ejecutar la accion */

        $error = [];
        if($request->get('name') == ''){
            $error['name'] = 'Ingrese un Nombre y Apellido';
        }
        if(strlen($request->get('name')) > 100){
            $error['name'] = 'El Nombre no puede exceder los 100 Caracteres';
        }
        if($request->get('celular') == ''){
            $error['celular'] = 'Ingrese un Numero de Telefono';
        }
        if($request->get('cedula') == ''){
            $error['cedula'] = 'Ingrese un Numero de Cedula';
        }
        if($request->get('email') == ''){
            $error['email'] = 'Ingrese un Usuario';
        }
        if(strlen($request->get('celular')) > 10){
            $error['celular'] = 'El Numero Celular no puede exceder los 10 Caracteres';
        }
        if(strlen($request->get('cedula')) > 11){
            $error['cedula'] = 'El Numero de Cedula no puede exceder los 11 Caracteres';
        }
        if(  User::where('cedula',$request->get('cedula'))->select('cedula')->first()    ){
            $error['cedula'] = 'El Numero de Cedula ya se encuentra registrado';
        }
        if(strlen($request->get('password')) < 8){
            $error['password'] = 'La contraseña es muy corta';
        }
        if(  User::where('email',$request->get('email'))->select('email')->first()    ){
            $error['email'] = 'Este Usuario ya se encuentra registrado';
        }
        if($error){
            return response()->json([ 'type' => 'error','data' => $error]);
        }else{
            $values = [
                'name' => $request->get('name'),
                'password' => bcrypt($request->get('password')),
                'cedula' => $request->get('cedula'),
                'email' => $request->get('email'),
                'nacimiento' => $request->get('nacimiento'),
                'celular' => $request->get('celular'),
            ];
            $current_item = new User($values);
            $current_item->save();
            return response()->json([ 'type' => 'success', 'data' => $current_item]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        /* Editar el usuario - primero se valida y despues se procede a ejecutar la accion */

        $error = [];
        if($request->get('name') == ''){
            $error['name'] = 'Ingrese un Nombre y Apellido';
        }
        if(strlen($request->get('name')) > 100){
            $error['name'] = 'El Nombre no puede exceder los 100 Caracteres';
        }
        if($request->get('celular') == ''){
            $error['celular'] = 'Ingrese un Numero de Telefono';
        }
        if(strlen($request->get('celular')) > 10){
            $error['celular'] = 'El Numero Celular no puede exceder los 10 Caracteres';
        }
        if($error){
            return response()->json([ 'type' => 'error','data' => $error]);
        }else{
            $current_item = User::find($id);
            $current_item->name = $request->get('name');
            $current_item->celular = $request->get('celular');
            $current_item->nacimiento = $request->get('nacimiento');
            $current_item->save();
            return response()->json([ 'type' => 'success', 'data' => $current_item]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $current_item = User::find($id);
        if($current_item){
            $current_item->delete();
            return response()->json([ 'type' => 'success']);
        }else{
            return response()->json([ 'type' => 'error']);
        }
    }

    public function service(Request $request)
    {
        /* FIELDS TO FILTER */
        $search = $request->get('search');

        /* QUERY FILTER */
        $query = User::where('name','LIKE','%'.$search.'%')
            ->orWhere('cedula','LIKE','%'.$search.'%')
            ->orWhere('email','LIKE','%'.$search.'%')
            ->orWhere('celular','LIKE','%'.$search.'%')->get();

        /* FIELDS DEFAULTS DATATABLES */
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $totalRecords = count(User::all());
        $totalRecordswithFilter = count($query);

        echo json_encode(array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $query
        ));
    }
}
