<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Palette_color;
use App\User;
use Auth;

class PaletteColorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('palette_colors.index');
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
        if($request->get('color_primary') == ''){
            $error['color_primary'] = 'Ingrese un Color';
        }
        if($request->get('color_secondary') == ''){
            $error['color_secondary'] = 'Ingrese un Color';
        }
        if($request->get('color_tertiary') == ''){
            $error['color_tertiary'] = 'Ingrese un Color';
        }
        if($error){
            return response()->json([ 'type' => 'error','data' => $error]);
        }else{
            $values = [
                'user_id' => 1,
                'color_primary' => $request->get('color_primary'),
                'color_secondary' => $request->get('color_secondary'),
                'color_tertiary' => $request->get('color_tertiary'),
                'active' => 0,
            ];
            $current_item = new Palette_color($values);
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
        if($request->get('color_primary') == ''){
            $error['color_primary'] = 'Ingrese un Color';
        }
        if($request->get('color_secondary') == ''){
            $error['color_secondary'] = 'Ingrese un Color';
        }
        if($request->get('color_tertiary') == ''){
            $error['color_tertiary'] = 'Ingrese un Color';
        }
        if($error){
            return response()->json([ 'type' => 'error','data' => $error]);
        }else{
            $current_item = Palette_color::find($id);
            $current_item->color_primary = $request->get('color_primary');
            $current_item->color_secondary = $request->get('color_secondary');
            $current_item->color_tertiary = $request->get('color_tertiary');
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
        $current_item = Palette_color::find($id);
        $current_item->delete();
        return response()->json([ 'type' => 'success']);
      
    }

    public function service(Request $request)
    {
        /* FIELDS TO FILTER */
        $search = $request->get('search');
        
        /* QUERY FILTER */
        $query = Palette_color::where('user_id','LIKE','%'.$search.'%')
            ->orWhere('color_primary','LIKE','%'.$search.'%')
            ->orWhere('color_secondary','LIKE','%'.$search.'%')
            ->orWhere('color_tertiary','LIKE','%'.$search.'%')
            ->orWhere('active','LIKE','%'.$search.'%')->get();
 
        /* FIELDS DEFAULTS DATATABLES */
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $totalRecords = count(Palette_color::all());
        $totalRecordswithFilter = count($query);
    
        echo json_encode(array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $query
        ));
    }

    public function perfil_colors_change(Request $request)
    {
        $current_all = Palette_color::where([
            ["active","=",1],
            ["user_id","=",Auth::user()->id],
            ["id","!=",$request->get('id')],
        ])->get();

        $current_item = Palette_color::where([
            ["id","=",$request->get('id')],
            ["user_id","=",Auth::user()->id],
        ])->first();

        $current_all->each(function ($item) {
            $current_one = Palette_color::find($item->id);
            $current_one->active = 0;
            $current_one->save();
        });

        $current_item->active = 1;
        $current_item->save();

        return response()->json([ 'type' => 'success', 'data' => $current_item]);

    }
}