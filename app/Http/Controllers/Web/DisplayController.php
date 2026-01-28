<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Display;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DisplayController extends Controller
{
    public function index(Request $request)
    {
        $query = Display::with('user', 'creator', 'updater');
        
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
        
        $displays = $query->orderBy('created_at', 'desc')->paginate(10);
        $users = User::all();
        
        return view('display.index', compact('displays', 'users'));
    }

    public function create()
    {
        $users = User::all();
        return view('display.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'maac_id' => 'required|string|max:255|unique:displays,maac_id',
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'resolution' => 'nullable|string',
            'status' => 'required|in:active,inactive,maintenance,out_of_order',
            'remarks' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $display = new Display();
        $display->maac_id = $request->maac_id;
        $display->name = $request->name;
        $display->location = $request->location;
        $display->resolution = $request->resolution;
        $display->status = $request->status;
        $display->remarks = $request->remarks;
        $display->user_id = $request->user_id;
        $display->created_by = Auth::id();
        $display->updated_by = Auth::id();
        
        $display->save();

        return redirect()->route('displays.index')
            ->with('success', 'Display created successfully!');
    }

    public function show($id)
    {
        $display = Display::with('user', 'creator', 'updater')->findOrFail($id);
        return view('display.show', compact('display'));
    }

    public function edit($id)
    {
        $display = Display::findOrFail($id);
        $users = User::all();
        return view('display.edit', compact('display', 'users'));
    }

    public function update(Request $request, $id)
    {
        $display = Display::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'maac_id' => 'required|string|max:255|unique:displays,maac_id,' . $id,
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'resolution' => 'nullable|string',
            'status' => 'required|in:active,inactive,maintenance,out_of_order',
            'remarks' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $display->maac_id = $request->maac_id;
        $display->name = $request->name;
        $display->location = $request->location;
        $display->resolution = $request->resolution;
        $display->status = $request->status;
        $display->remarks = $request->remarks;
        $display->user_id = $request->user_id;
        $display->updated_by = Auth::id();
        
        $display->save();

        return redirect()->route('displays.index')
            ->with('success', 'Display updated successfully!');
    }

    public function destroy($id)
    {
        $display = Display::findOrFail($id);
        $display->delete();

        return redirect()->route('displays.index')
            ->with('success', 'Display deleted successfully!');
    }
}