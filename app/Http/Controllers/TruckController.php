<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Truck;
use Illuminate\Validation\Rule;
use App\Models\Asignacion;
use MongoDB\BSON\ObjectId;


class TruckController extends Controller
{
    public function index()
    {
        return view('trucks.camiones');
    }

    public function data()
    {
        $trucks = Truck::get()->map(function ($truck) {
            return [
                'id'     => (string)$truck->_id,
                'plates' => $truck->plates,
                'brand'  => $truck->brand,
                'model'  => $truck->model,
                'year'   => $truck->year,
                'status' => $truck->status,
                'image'  => $truck->image,
            ];
        });
        return response()->json(['data' => $trucks]);
    }

    public function store(Request $request)
    {
        $rules = [
            'plates' => [
                'required',
                'regex:/^[A-Za-z]{3}-\d{3}-[A-Za-z]{1}$/',
                'unique:trucks,plates'
            ],
            'brand'  => ['required', 'max:15', 'regex:/^[A-Za-z\s]+$/'],
            'model'  => ['required', 'max:15', 'regex:/^[A-Za-z\s]+$/'],
            'year'   => 'required|integer',
            'status' => 'required',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $validated = $request->validate($rules);

        // Convertir las placas a mayúsculas
        $plates = strtoupper($request->input('plates'));

        // Formatear marca y modelo para que cada palabra inicie en mayúsculas
        $brand = ucwords(strtolower($request->input('brand')));
        $model = ucwords(strtolower($request->input('model')));

        // Procesar la imagen del camión
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $ruta = $image->storeAs('imagenes_camiones', $imageName, 'public');
        } else {
            $ruta = null;
        }

        Truck::create([
            'plates' => $plates,
            'brand'  => $brand,
            'model'  => $model,
            'status' => $request->input('status'),
            'year'   => $request->input('year'),
            'image'  => $ruta,
        ]);

        return redirect()->route('admin.trucks.index')
            ->with('truckStored', 'Camión registrado correctamente.');
    }





    public function show($id)
    {
        $truck = Truck::find($id);

        if (!$truck) {
            return response()->json(['error' => 'Camión no encontrado'], 404);
        }

        return response()->json([
            'data' => [
                'plates' => $truck->plates,
                'brand'  => $truck->brand,
                'model'  => $truck->model,
                'year'   => $truck->year,
                'status' => $truck->status,
                'image'  => $truck->image,
            ]
        ]);
    }


    public function update(Request $request, $id)
    {
        $truck = Truck::find($id);

        if (!$truck) {
            return redirect()->back()->with('error', 'Camión no encontrado');
        }

        $rules = [
            'plates'  => [
                'required',
                // Se fuerza el formato: 3 letras, un guion, 3 números, un guion, 1 letra.
                'regex:/^[A-Za-z]{3}-\d{3}-[A-Za-z]{1}$/',
                Rule::unique('trucks', 'plates')->ignore($truck->_id, '_id')
            ],
            'brand'   => ['required', 'max:15', 'regex:/^[A-Za-z\s]+$/'],
            'model'   => ['required', 'max:15', 'regex:/^[A-Za-z\s]+$/'],
            'year'    => 'required|integer',
            'status'  => 'required',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $validated = $request->validate($rules);

        // Procesar la imagen si se actualiza
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $ruta = $image->storeAs('imagenes_camiones', $imageName, 'public');
        } else {
            $ruta = $truck->image;
        }

        // Convertir placas a mayúsculas
        $plates = strtoupper($request->input('plates'));

        // Formatear marca y modelo: cada palabra con la primera letra en mayúsculas y el resto en minúsculas
        $brand = ucwords(strtolower($request->input('brand')));
        $model = ucwords(strtolower($request->input('model')));

        $truck->plates = $plates;
        $truck->brand  = $brand;
        $truck->model  = $model;
        $truck->year   = $request->input('year');
        $truck->status = $request->input('status');
        $truck->image  = $ruta;

        $truck->save();

        return redirect()->route('admin.trucks.index')
            ->with('truckUpdated', 'Camión actualizado correctamente.');
    }





    public function destroy($id)
    {
        $truck = Truck::find($id);

        if (!$truck) {
            return response()->json(['success' => false, 'message' => 'Camión no encontrado'], 404);
        }

        $truckIdObject = new ObjectId($truck->getKey());

        // Comprobar si el camión tiene asignaciones activas
        if (Asignacion::where('idCamion', $truckIdObject)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar el camión porque tiene asignaciones activas.'
            ], 400);
        }

        $truck->delete();

        return response()->json(['success' => true, 'message' => 'Camión eliminado correctamente']);
    }

    public function camionesActivos()
    {
        // 1. Query only for trucks with 'activo' status
        $activeTrucks = Truck::where('status', 'Activo')->get();

        // 2. Map the results to the desired structure (same as in data() method)
        $structuredTrucks = $activeTrucks->map(function ($truck) {
            return [
                'id'     => (string)$truck->_id, // Cast _id to string
                'plates' => $truck->plates,
                'brand'  => $truck->brand,
                'model'  => $truck->model,
                'year'   => $truck->year,
                'status' => $truck->status, // This will always be 'activo' due to the query
                'image'  => $truck->image,
            ];
        });

        // 3. Return the response wrapped in a 'data' key
        return response()->json(['data' => $structuredTrucks]);
    }
}


