<?php

namespace App\Http\Controllers;

use App\Models\Shelves;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Opens_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('opens.index');
    }

    public function getstores()
    {
        $storehouseslist = DB::table('stores')->where('state', 0)->get();
        $result = [
            'data' =>  $storehouseslist
        ];
        return response()->json($result);
    }

    public function lists(Request $request)
    {
       $storehouseslist = DB::table('stores')->where('state', 0)->get();
       $result = [
            'data' =>  $storehouseslist
        ];
        return response()->json($result);
    }

    public function products(Request $request, $id)
    {
        $skip =$request['start'] * $request['take'];
        $products = DB::table('products')
            ->where('active', 1);
        $filtros = json_decode($request['fillter'], true);
        $order = json_decode($request['order'], true);
        if ( $filtros['name'] !== "" )  $products->where('name', 'LIKE',  "%".$filtros['name']."%");
        if ( $filtros['code'] !== "" )  $products->where('code', 'LIKE',  "%".$filtros['code']."%");
        $products->orderby($order['field'], $order['type'] );
        $total = $products->select('id', 'name', 'code')->count();
        $productlist = $products->skip($skip)->take($request['take'])->get();
        $shelves = DB::table('shelves')->select('id', 'name')->where('idstore', $id)->get();
        $result = [
            'total' => $total,
            'data' => $productlist,
            'shelves' => $shelves,
        ];
        return response()->json($result);
    }

    public function store(Request $request)
    {
        //
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
        //
    }
}
