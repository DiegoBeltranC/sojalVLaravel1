<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Truck;

class TruckControllerApi extends Controller
{
    public function index()
    {
        $camiones = Truck::all();
        return response()->json($camiones);
    }

    public function store(Request $request)
    {
        $rules = [
            'plates' => 'required',
             'brand' => 'required',
             'model' => 'required',
             'year' => 'required|integer',
             'status' => 'required',
         ];
 
 
         $validated = $request->validate($rules);

         $plates    = $request->plates;
         $brand = $request->brand;
         $model = $request->model;
         $status = $request->status;
         $year = $request->year;

         $camiones = Truck::create([
            'plates' => $plates,
            'brand' => $brand,
            'model' => $model,
            'status' => $status,
            'year' => $year,
        ]);

        return response()->json($camiones, 201);
    }

    public function show($id)
    {
        $truck = Truck::find($id);

        return response()->json([
            'data' => [
                'plates'        => $truck->plates,
                'brand' => $truck->brand,
                'model'      => $truck->model,
                'status'        => $truck->status,
                'year'           => $truck->year,
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $camiones = Truck::find($id);

        $rules = [
            'plates' => 'required',
             'brand' => 'required',
             'model' => 'required',
             'year' => 'required|integer',
             'status' => 'required',
         ];

        $validated = $request->validate($rules);

        $plates    = $request->plates;
        $brand = $request->brand;
        $model = $request->model;
        $status = $request->status;
        $year = $request->year;

        $camiones->plates = $plates;       
        $camiones->brand = $brand;
        $camiones->model = $model;
        $camiones->status = $status;
        $camiones->year = $year;

        $camiones->save();
        
        return response()->json($camiones);
    }

    public function destroy($id)
    {
        $camiones = Truck::find($id);

        $camiones->delete();

        return response()->json(['success' => true, 'message' => ' eliminado correctamente']);
    }
}
