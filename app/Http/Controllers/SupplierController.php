<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();

        return response()->json($suppliers, 200);
    }

    public function show($id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return response()->json(['mensaje' => 'Proveedor no encontrado'], 404);
        }

        return response()->json($supplier, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'cellphone' => 'required',
            'company' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $supplier = Supplier::create($request->all());

        return response()->json(['mensaje' => 'Proveedor creado con éxito', 'proveedor' => $supplier], 201);

    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return response()->json(['mensaje' => 'Proveedor no encontrado'], 404);
        }

        $supplier->update($request->all());

        return response()->json(['mensaje' => 'Proveedor actualizado con éxito', 'proveedor' => $supplier], 200);
    }

    public function destroy($id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return response()->json(['mensaje' => 'Proveedor no encontrado'], 404);
        }

        $supplier->delete();

        return response()->json(['mensaje' => 'Proveedor eliminado con éxito'], 200);
    }
}
