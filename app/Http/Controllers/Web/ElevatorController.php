<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Elevator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ElevatorController extends Controller
{
    public function index(Request $request)
    {
        $query = Elevator::with('user', 'creator', 'updater');
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('maac_id', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }
        
        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // User filter
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        
        $elevators = $query->orderBy('created_at', 'desc')->paginate(10);
        $users = User::all();
        
        return view('elevator.index', compact('elevators', 'users'));
    }

    public function create()
    {
        $users = User::all();
        return view('elevator.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'maac_id' => 'required|string|max:255|unique:elevators,maac_id',
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'capacity' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive,maintenance,out_of_order',
            'remarks' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $elevator = new Elevator();
        $elevator->maac_id = $request->maac_id;
        $elevator->name = $request->name;
        $elevator->location = $request->location;
        $elevator->capacity = $request->capacity;
        $elevator->status = $request->status;
        $elevator->remarks = $request->remarks;
        $elevator->user_id = $request->user_id;
        $elevator->created_by = Auth::id();
        $elevator->updated_by = Auth::id();
        
        $elevator->save();

        return redirect()->route('elevators.index')
            ->with('success', 'Elevator created successfully!');
    }

    public function show($id)
    {
        $elevator = Elevator::with('user', 'creator', 'updater')->findOrFail($id);
        return view('elevator.show', compact('elevator'));
    }

    public function edit($id)
    {
        $elevator = Elevator::findOrFail($id);
        $users = User::all();
        return view('elevator.edit', compact('elevator', 'users'));
    }

    public function update(Request $request, $id)
    {
        $elevator = Elevator::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'maac_id' => 'required|string|max:255|unique:elevators,maac_id,' . $id,
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'capacity' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive,maintenance,out_of_order',
            'remarks' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $elevator->maac_id = $request->maac_id;
        $elevator->name = $request->name;
        $elevator->location = $request->location;
        $elevator->capacity = $request->capacity;
        $elevator->status = $request->status;
        $elevator->remarks = $request->remarks;
        $elevator->user_id = $request->user_id;
        $elevator->updated_by = Auth::id();
        
        $elevator->save();

        return redirect()->route('elevators.index')
            ->with('success', 'Elevator updated successfully!');
    }

    public function destroy($id)
    {
        $elevator = Elevator::findOrFail($id);
        $elevator->delete();

        return redirect()->route('elevators.index')
            ->with('success', 'Elevator deleted successfully!');
    }
}