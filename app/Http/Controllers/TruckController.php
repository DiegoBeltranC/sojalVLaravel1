<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Truck;

class TruckController extends Controller
{
    // Esta propiedad se definirá en el controlador hijo.

    public function index()
    {
        return view('trucks.camiones');
    }

    public function data()
    {
        $trucks = Truck::get()->map(function ($truck) {
            return [
                'id'        => (string)$truck->_id,
                'plates'    => $truck->plates,
                'brand' => $truck->brand,
                'model'    => $truck->model,
                'year'  => $truck->year,
                'status'  => $truck->status,
                // Agrega más campos si lo requieres
            ];
        });
        return response()->json(['data' => $trucks]);
    }

    public function store(Request $request)
    {
        // Validación. Nota: si en algún caso (por ejemplo, en ciudadanos) no se requieren
        // ciertos campos, puedes ajustar la validación según el rol.
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

        Truck::create([
            'plates' => $plates,
            'brand' => $brand,
            'model' => $model,
            'status' => $status,
            'year' => $year,
        ]);

        return redirect()->route('admin.trucks.index');
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
        $truck = Truck::find($id);

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

        $truck->plates = $plates;       
        $truck->brand = $brand;
        $truck->model = $model;
        $truck->status = $status;
        $truck->year = $year;

        $truck->save();
        
        return redirect()->route('admin.trucks.index');    
    }

    public function destroy($id)
    {
        $truck = Truck::find($id);

       

        $truck->delete();

        return response()->json(['success' => true, 'message' => ' eliminado correctamente']);
    }
}




