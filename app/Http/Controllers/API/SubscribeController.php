<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Exception;

class SubscribeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            //$subscribes = Subscribe::with(['client', 'service', 'screen', 'creator'])->get();
            $subscribes = Subscribe::all();
            return response()->json();
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch subscribes', 'details' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'client' => 'required|exists:clients,id',
                'service' => 'required|exists:services,id',
                'screen' => 'required|exists:screens,id',
                'plan' => 'required'
                //'start' => 'required|date',
                //'end' => 'required|date|after_or_equal:start',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $data = $request->all();
            $data['created_by'] = auth()->id();

            $plan = Plan::find($data['plan']);

            $latestSubscription = Subscribe::where('client', $data['client'])
                ->where('screen',  $data['screen'])
                ->orderBy('created_at', 'desc')
                ->first();

            if (isset($latestSubscription->end)) {
                if (Carbon::now()->gt(Carbon::create($latestSubscription->end))) {
                    unset($latestSubscription);
                }
            }

            $data['start'] = isset($latestSubscription->end) ? Carbon::create($latestSubscription->end)->addDay() : Carbon::now();
            $data['end']= isset($latestSubscription->end) ? Carbon::create($latestSubscription->end)->addDay()->addDays($plan->days) :  Carbon::now()->addDays($plan->days);

            $subscribe = Subscribe::create($data);

            return response()->json($subscribe, Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to create subscribe', 'details' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $subscribe = Subscribe::with(['client', 'service', 'screen', 'creator'])->find($id);

            if (!$subscribe) {
                return response()->json(['message' => 'Subscribe not found'], Response::HTTP_NOT_FOUND);
            }

            return response()->json($subscribe);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch subscribe', 'details' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $subscribe = Subscribe::find($id);

            if (!$subscribe) {
                return response()->json(['message' => 'Subscribe not found'], Response::HTTP_NOT_FOUND);
            }

            $validator = Validator::make($request->all(), [
                'client' => 'required|exists:clients,id',
                'service' => 'required|exists:services,id',
                'screen' => 'nullable|exists:screens,id',
                'start' => 'required|date',
                'end' => 'required|date|after_or_equal:start',
                'created_by' => 'required|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $subscribe->update($request->all());

            return response()->json($subscribe);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to update subscribe', 'details' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $subscribe = Subscribe::find($id);

            if (!$subscribe) {
                return response()->json(['message' => 'Subscribe not found'], Response::HTTP_NOT_FOUND);
            }

            $subscribe->delete();

            return response()->json(['message' => 'Subscribe deleted successfully'], Response::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete subscribe', 'details' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
