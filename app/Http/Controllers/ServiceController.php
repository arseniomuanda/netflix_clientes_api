<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ServiceController extends Controller
{
    public function index()
    {
        return response()->json(Service::all(), 200);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'abreviation' => 'required|string|max:10',
                'logo' => 'nullable|string|max:255',
                'created_by' => 'required|uuid|exists:users,id',
            ]);

            $service = Service::create($validated);

            return response()->json($service, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function show($id)
    {
        $service = Service::findOrFail($id);

        return response()->json($service, 200);
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        try {
            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:100',
                'abreviation' => 'sometimes|required|string|max:10',
                'logo' => 'nullable|string|max:255',
            ]);

            $service->update($validated);

            return response()->json($service, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        $service->delete();

        return response()->json(null, 204);
    }
}
