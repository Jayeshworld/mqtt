<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Elevator;
use Illuminate\Http\Request;

class ElevatorController extends Controller
{
    public function maacid()
    {
        $elevators = Elevator::all();

        return response()->json(['maac_id' => $elevators->pluck('maac_id')]);
    }

    public function notification(Request $request)
    {
        // Logic to handle notification
        return response()->json(['message' => 'Notification received']);
    }
}
