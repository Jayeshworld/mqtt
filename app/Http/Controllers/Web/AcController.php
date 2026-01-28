<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Ac;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AcController extends Controller
{
    public function index(Request $request)
    {
        $query = Ac::with('user', 'creator', 'updater');
        
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
        
        $acs = $query->orderBy('created_at', 'desc')->paginate(10);
        $users = User::all();
        
        return view('ac.index', compact('acs', 'users'));
    }

    public function create()
    {
        $users = User::all();
        return view('ac.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'maac_id' => 'required|string|max:255|unique:acs,maac_id',
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'capacity' => 'nullable|integer',
            'status' => 'required|in:active,inactive,maintenance,out_of_order',
            'remarks' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $ac = new Ac();
        $ac->maac_id = $request->maac_id;
        $ac->name = $request->name;
        $ac->location = $request->location;
        $ac->capacity = $request->capacity;
        $ac->status = $request->status;
        $ac->remarks = $request->remarks;
        $ac->user_id = $request->user_id;
        $ac->created_by = Auth::id();
        $ac->updated_by = Auth::id();
        
        $ac->save();

        return redirect()->route('acs.index')
            ->with('success', 'AC created successfully!');
    }

    public function show($id)
    {
        $ac = Ac::with('user', 'creator', 'updater')->findOrFail($id);
        return view('ac.show', compact('ac'));
    }

    public function edit($id)
    {
        $ac = Ac::findOrFail($id);
        $users = User::all();
        return view('ac.edit', compact('ac', 'users'));
    }

    public function update(Request $request, $id)
    {
        $ac = Ac::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'maac_id' => 'required|string|max:255|unique:acs,maac_id,' . $id,
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'capacity' => 'nullable|integer',
            'status' => 'required|in:active,inactive,maintenance,out_of_order',
            'remarks' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $ac->maac_id = $request->maac_id;
        $ac->name = $request->name;
        $ac->location = $request->location;
        $ac->capacity = $request->capacity;
        $ac->status = $request->status;
        $ac->remarks = $request->remarks;
        $ac->user_id = $request->user_id;
        $ac->updated_by = Auth::id();
        
        $ac->save();

        return redirect()->route('acs.index')
            ->with('success', 'AC updated successfully!');
    }

    public function destroy($id)
    {
        $ac = Ac::findOrFail($id);
        $ac->delete();

        return redirect()->route('acs.index')
            ->with('success', 'AC deleted successfully!');
    }
}