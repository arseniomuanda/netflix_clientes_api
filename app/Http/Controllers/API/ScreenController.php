<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Screen;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ScreenController extends Controller
{
    public function index()
    {
        return response()->json(Screen::all(), 200);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:20',
                'account' => 'required|exists:accounts,id',
                'client' => 'required|exists:clients,id',
                'pin' => 'nullable|numeric|digits:4'
            ]);

            $validated['created_by'] = auth()->id();

            $screen = Screen::create($validated);

            return response()->json($screen, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function show($id)
    {
        $screen = Screen::findOrFail($id);

        return response()->json($screen, 200);
    }

    public function update(Request $request, $id)
    {
        $screen = Screen::findOrFail($id);

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:20',
                'account' => 'required|exists:accounts,id',
                'client' => 'required|exists:clients,id',
                'pin' => 'nullable|numeric|digits:4'
            ]);

            $screen->update($validated);

            return response()->json($screen, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function destroy($id)
    {
        $screen = Screen::findOrFail($id);

        $screen->delete();

        return response()->json(null, 204);
    }
}
