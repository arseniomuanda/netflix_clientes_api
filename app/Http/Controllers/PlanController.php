<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class PlanController extends Controller
{
    // Lista todos os planos
    public function index()
    {
        try {
            $plans = Plan::all();
            return response()->json($plans);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao listar planos',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Cria um novo plano
    public function store(Request $request)
    {
        try {
            // Validação dos dados
            $validated = $request->validate([
                'discriptions' => 'nullable|string|max:255',
                'value' => 'required|numeric',
                'days' => 'required|integer',
            ]);

            // Criação do plano
            $plan = Plan::create([
                'discriptions' => $validated['discriptions'],
                'value' => $validated['value'],
                'days' => $validated['days'],
                'created_by' => Auth::id(), // Usuário autenticado
            ]);

            return response()->json($plan, Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $e->errors(),
            ], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar plano',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Exibe um plano específico
    public function show($id)
    {
        try {
            $plan = Plan::findOrFail($id);
            return response()->json($plan);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Plano não encontrado',
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao exibir plano',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Atualiza um plano existente
    public function update(Request $request, $id)
    {
        try {
            $plan = Plan::findOrFail($id);

            // Validação dos dados
            $validated = $request->validate([
                'discriptions' => 'nullable|string|max:255',
                'value' => 'required|numeric',
                'days' => 'required|integer',
            ]);

            // Atualização do plano
            $plan->update([
                'discriptions' => $validated['discriptions'],
                'value' => $validated['value'],
                'days' => $validated['days'],
            ]);

            return response()->json($plan);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Plano não encontrado',
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $e->errors(),
            ], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar plano',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Deleta um plano
    public function destroy($id)
    {
        try {
            $plan = Plan::findOrFail($id);
            $plan->delete();

            return response()->json(['message' => 'Plano deletado com sucesso']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Plano não encontrado',
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar plano',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
