<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Models\Department;
use App\Models\Level;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::All();
        $levels = Level::All();
        return view('users.index')->with('departments',$departments)->with('levels',$levels);
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
        if($request->get('email') == ''){
            $error['email'] = 'Ingrese un Usuario';
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
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
                'level_id' => $request->get('level_id'),
                'department_id' => $request->get('department_id'),
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
        $query = User::select('users.*','departments.name AS nameDepartment','levels.name AS nameLevel')
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->join('levels', 'users.level_id', '=', 'levels.id')
            ->where('users.name','LIKE','%'.$search.'%')
            ->orWhere('users.email','LIKE','%'.$search.'%')
            ->get();

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
