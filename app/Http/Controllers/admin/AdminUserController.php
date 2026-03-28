<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_blocked', $request->status == 'blocked' ? true : false);
        }

        $users = $query->orderBy('created_at', 'desc')
                      ->paginate($request->get('per_page', 10))
                      ->withQueryString();

        return view('admin.user', compact('users'));
    }

    /**
     * Show form to create a new user
     */
    public function create()
    {
        return view('admin.add-user');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'address' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'is_blocked' => false,
        ]);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User created successfully!');
    }

    /**
     * Display the specified user
     */
    public function show($id)
    {
        $user = User::with(['orders'])->findOrFail($id);
        return view('admin.view-user', compact('user'));
    }

    /**
     * Show form to edit the specified user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'password' => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting the last admin or yourself (if needed)
        $user->delete();

        return redirect()->route('admin.users.index')
                        ->with('success', 'User deleted successfully!');
    }

    /**
     * Block a user
     */
    public function block($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_blocked' => true]);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User has been blocked successfully!');
    }

    /**
     * Unblock a user
     */
    public function unblock($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_blocked' => false]);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User has been unblocked successfully!');
    }

    /**
     * Bulk operations on users
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'action' => 'required|in:block,unblock,delete',
        ]);

        $userIds = $request->user_ids;
        $action = $request->action;

        switch ($action) {
            case 'block':
                User::whereIn('id', $userIds)->update(['is_blocked' => true]);
                $message = 'Selected users have been blocked successfully!';
                break;

            case 'unblock':
                User::whereIn('id', $userIds)->update(['is_blocked' => false]);
                $message = 'Selected users have been unblocked successfully!';
                break;

            case 'delete':
                User::whereIn('id', $userIds)->delete();
                $message = 'Selected users have been deleted successfully!';
                break;
        }

        return redirect()->route('admin.users.index')
                        ->with('success', $message);
    }
}
