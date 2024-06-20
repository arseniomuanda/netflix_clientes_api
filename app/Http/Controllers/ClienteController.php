<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Cliente::all();

        return ApiResponseClass::sendResponse($data, '', 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'telefone' => 'required',
            'email' => 'nullable|email'
        ]);

        // Verifique se a validação falhou
        if ($validator->fails()) {
            // Retorne os erros em formato JSON
            return response()->json($validator->errors(), 422);
        }
        $data = $request->all();

        DB::beginTransaction();
        try {
            $cliente = Cliente::create($data);

            DB::commit();
            return ApiResponseClass::sendResponse($cliente, 'Product Create Successful', 201);
        } catch (\Exception $ex) {
            throw $ex;

            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cliente = Cliente::find($id);
        return ApiResponseClass::sendResponse($cliente, '', 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => "required|string",
            'telefone' => "string|min:9|nullable",
            'email' => "email|nullable"
        ]);

        // Verifique se a validação falhou
        if ($validator->fails()) {
            // Retorne os erros em formato JSON
            return response()->json($validator->errors(), 422);
        }
        $data = $request->all();
        $cliente = Cliente::find($id);
        DB::beginTransaction();

        try {
            $cliente->update($data);

            DB::commit();
            return ApiResponseClass::sendResponse('Cliente actualizado', '', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cliente = Cliente::find($id);
        $cliente->delete();
        return ApiResponseClass::sendResponse('Cliente Delete Successful', '', 204);
    }
}
