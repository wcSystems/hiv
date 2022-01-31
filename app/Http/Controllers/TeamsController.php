<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masters = Team::leftjoin('teams as master','master.id','=','teams.team_id')
                       ->where('teams.group','!=','0')
                       ->get([
                            'teams.*',
                            'master.title as master'
                        ]);
        return view('teams.index')->with('masters',$masters);
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
        if($error){
            return response()->json([ 'type' => 'error','data' => $error]);
        }else{
            $values = [
                'group' => $request->get('group'),
                'title' => $request->get('title'),
                'team_id' => $request->get('team_id'),
                'ip' => $request->get('ip'),
                'user' => $request->get('user'),
                'password' => $request->get('password'),
                'description' => $request->get('description')
            ];
            $current_item = new Team($values);
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
        $current_item = Team::find($id);
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

        /* $query = Team::where('ip','LIKE','%'.$search.'%')
            ->orWhere('title','LIKE','%'.$search.'%')
            ->orWhere('user','LIKE','%'.$search.'%')
            ->orWhere('password','LIKE','%'.$search.'%')
            ->orWhere('description','LIKE','%'.$search.'%')->get(); */
            $query =Team::all();

        /* FIELDS DEFAULTS DATATABLES */
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $totalRecords = count(Team::all());
        $totalRecordswithFilter = count($query);

        echo json_encode(array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $query
        ));
    }
}
