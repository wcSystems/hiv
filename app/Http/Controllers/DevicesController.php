<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Device;
use App\Block;
use App\Type;
use App\Network;

use App\Exports\DevicesExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class DevicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blocks=Block::all();
        $types=Type::all();
        $networks=Network::all();
        return view('devices.index')->with('blocks',$blocks)->with('types',$types)->with('networks',$networks);
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
                'network_id' => $request->get('network_id'),
                'host' => $request->get('host'),
                'type_id' => $request->get('type_id'),
                'name' => $request->get('name'),
                'block_id' => $request->get('block_id'),
                'username' => $request->get('username'),
                'password' => $request->get('password'),
                'ssid' => $request->get('ssid'),
                'ssid_password' => $request->get('ssid_password'),
                'mac' => $request->get('mac'),
                'description' => $request->get('description'),
            ];
            $current_item = new Device($values);
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

        if($error){
            return response()->json([ 'type' => 'error','data' => $error]);
        }else{
            $current_item = Device::find($id);
            $current_item->network_id = $request->get('network_id');
            $current_item->host = $request->get('host');
            $current_item->type_id = $request->get('type_id');
            $current_item->name = $request->get('name');
            $current_item->block_id = $request->get('block_id');
            $current_item->username = $request->get('username');
            $current_item->password = $request->get('password');
            $current_item->ssid = $request->get('ssid');
            $current_item->ssid_password = $request->get('ssid_password');
            $current_item->mac = $request->get('mac');
            $current_item->description = $request->get('description');
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
        $current_item = Device::find($id);
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
        $search_network = $request->get('search_network');
        $search_type = $request->get('search_type');
        $search_block = $request->get('search_block');






            $query = DB::table('devices')
            ->orWhere(function($query) use ($search){
                $query->orWhere('host','LIKE','%'.$search.'%');
                $query->orWhere('name','LIKE','%'.$search.'%');
                $query->orWhere('username','LIKE','%'.$search.'%');
                $query->orWhere('password','LIKE','%'.$search.'%');
                $query->orWhere('ssid','LIKE','%'.$search.'%');
                $query->orWhere('ssid_password','LIKE','%'.$search.'%');
                $query->orWhere('mac','LIKE','%'.$search.'%');
                $query->orWhere('description','LIKE','%'.$search.'%');
            })
            ->where(function($query) use ($search_network,$search_type,$search_block){
                if(!empty($search_network)){
                    $query->where('network_id', '=', $search_network);
                }else{};
                if(!empty($search_type)){
                    $query->where('type_id', '=', $search_type);
                }else{};
                if(!empty($search_block)){
                    $query->where('block_id', '=', $search_block);
                }else{};
            })
            ->get();

        /* FIELDS DEFAULTS DATATABLES */
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $totalRecords = count(Device::all());
        $totalRecordswithFilter = count($query);

        echo json_encode(array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $query
        ));
    }

    public function export()
    {
        $current_item = Device::all();
        return Excel::download( new DevicesExport( $current_item ),'users.xls');
    }
}
