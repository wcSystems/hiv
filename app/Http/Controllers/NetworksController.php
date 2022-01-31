<?php

namespace App\Http\Controllers;
use App\Network;

use Illuminate\Http\Request;

class NetworksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('networks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $error = [];
        if($request->get('a') == ''){
            $error['a'] = 'Ingrese un Numero';
        }
        if(strlen($request->get('a')) > 3){
            $error['a'] = 'Error de Longitud';
        }
        if($request->get('b') == ''){
            $error['b'] = 'Ingrese un Numero';
        }
        if(strlen($request->get('b')) > 3){
            $error['b'] = 'Error de Longitud';
        }
        if($request->get('c') == ''){
            $error['c'] = 'Ingrese un Numero';
        }
        if(strlen($request->get('c')) > 3){
            $error['c'] = 'Error de Longitud';
        }
        if($error){
            return response()->json([ 'type' => 'error','data' => $error]);
        }else{
            $values = [
                'a' => $request->get('a'),
                'b' => $request->get('b'),
                'c' => $request->get('c'),
            ];
            $current_item = new Network($values);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $error = [];
        if($request->get('a') == ''){
            $error['a'] = 'Ingrese un Numero';
        }
        if(strlen($request->get('a')) > 3){
            $error['a'] = 'Error de Longitud';
        }
        if($request->get('b') == ''){
            $error['b'] = 'Ingrese un Numero';
        }
        if(strlen($request->get('b')) > 3){
            $error['b'] = 'Error de Longitud';
        }
        if($request->get('c') == ''){
            $error['c'] = 'Ingrese un Numero';
        }
        if(strlen($request->get('c')) > 3){
            $error['c'] = 'Error de Longitud';
        }
        if($error){
            return response()->json([ 'type' => 'error','data' => $error]);
        }else{
            $current_item = Network::find($id);
            $current_item->a = $request->get('a');
            $current_item->b = $request->get('b');
            $current_item->c = $request->get('c');
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
        $current_item = Network::find($id);
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
        $query = Network::where('a','LIKE','%'.$search.'%')
            ->orWhere('b','LIKE','%'.$search.'%')
            ->orWhere('c','LIKE','%'.$search.'%')->get();

        /* FIELDS DEFAULTS DATATABLES */
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $totalRecords = count(Network::all());
        $totalRecordswithFilter = count($query);

        echo json_encode(array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $query
        ));
    }
}
