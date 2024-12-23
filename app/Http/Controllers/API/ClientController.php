<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    public function index()
    {
        return response()->json(Client::all(), 200);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'phone' => 'required|string|size:9',
                'photo' => 'nullable|file',
                'whatsapp' => 'nullable|string|max:19|unique:clients,whatsapp',
                'email' => 'nullable|email|max:150|unique:clients,email',
            ]);

            //return response()->json($user);

            $validated['created_by'] = auth()->id();


            $client = Client::create($validated);

            return response()->json($client, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function show($id)
    {
        $client = Client::findOrFail($id);

        return response()->json($client, 200);
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        try {
            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:100',
                'phone' => 'nullable|string|size:9',
                'photo' => 'sometimes|required|string|max:255',
                'whatsapp' => 'nullable|string|max:19|unique:clients,whatsapp,' . $client->id,
                'email' => 'nullable|email|max:150|unique:clients,email,' . $client->id,
            ]);

            $client->update($validated);

            return response()->json($client, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);

        $client->delete();

        return response()->json(null, 204);
    }
}
