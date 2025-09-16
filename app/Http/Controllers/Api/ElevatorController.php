<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FirebaseNotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Elevator;
use App\Models\Notifications;
use App\Models\User;
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

        // [2025-09-16 11:39:31] local.INFO: Notification received {"macid":"MAAC-0003|Relay1_Status|ON"} 

        $rawResponse = $request->input('macid');
        $macid = explode('|', $rawResponse)[0] ?? null;
        $key = explode('|', $rawResponse)[1] ?? null;
        $value = explode('|', $rawResponse)[2] ?? null;

        Log::info('Parsed notification', [
            'macid' => $macid,
            'key' => $key,
            'value' => $value,
        ]);

        $userId = Elevator::where('maac_id', $macid)->value('user_id');
        Log::info('User ID found', ['user_id' => $userId]);
        $user = $userId ? User::find($userId) : null; 

        $notification = 'Elevator ' . $macid . ' ' . $key . ' is ' . $value;

        $notification= Notifications::create([
            'user_ids' => $user ? [$user->id] : [],
            'title' => 'Elevator Status Changed',
            'body' => $notification,
            'type' => 'user',
        ]);
        
        FirebaseNotificationHelper::sendNotification($notification);

        

        // Logic to handle notification
        return response()->json([
            'message' => 'Notification received',
            'request' => $request->all()
        ]);
    }
}
