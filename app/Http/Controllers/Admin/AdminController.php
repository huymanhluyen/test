<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $data = $request->validate([
            'search' => 'nullable|string|max:100',
        ]);
        $search = trim($data['search'] ?? '');
        $users = \App\Models\User::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('age', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }
    public function create()
    {
        return view('admin.create');
    }
    public function edit($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('admin.edit', compact('user'));
    }
    public function delete($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:12',
            'age' => 'nullable|integer|min:1|max:120',
        ]);

        $user = \App\Models\User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->location = $request->location;
        $user->phone = $request->phone;
        $user->age = $request->age;
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully.');
    }
public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:12',
            'age' => 'nullable|integer|min:1|max:120',
        ]);

        $user = new \App\Models\User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->location = $request->location;
        $user->phone = $request->phone;
        $user->age = $request->age;
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User created successfully.');
    }
}