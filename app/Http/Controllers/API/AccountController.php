<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    public function index()
    {
        return response()->json(Account::all(), 200);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'nullable|string|max:100',
                'username' => 'required|email|max:150|unique:accounts,username',
                'password' => 'nullable|string|max:100',
            ]);

            $validated['created_by'] = auth()->id();


            $account = Account::create($validated);

            return response()->json($account, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function show($id)
    {
        $account = Account::findOrFail($id);

        return response()->json($account, 200);
    }

    public function update(Request $request, $id)
    {
        $account = Account::findOrFail($id);

        try {
            $validated = $request->validate([
                'name' => 'nullable|string|max:100',
                'username' => 'required|email|max:150|unique:accounts,email',
                'password' => 'nullable|string|max:100',
            ]);

            $account->update($validated);

            return response()->json($account, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function destroy($id)
    {
        $account = Account::findOrFail($id);

        $account->delete();

        return response()->json(null, 204);
    }
}
