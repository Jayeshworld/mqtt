<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Elevator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ElevatorController extends Controller
{
    public function maacid()
    {
        $elevators = Elevator::all();

        return response()->json(['maac_id' => $elevators->pluck('maac_id')]);
    }

    public function notification(Request $request)
    {
        Log::info('Notification received', $request->all());
        // Logic to handle notification
        return response()->json(['message' => 'Notification received']);
    }
}
