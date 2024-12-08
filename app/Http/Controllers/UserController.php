<?php

namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roleInfo')->get();

        return response()->json(['data'=> $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $data = $request->all();
        $data['description'] = strip_tags(trim($data['description']));

        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'phone' => 'required|numeric|digits:10',
            'description' => [
                'required',
                'string',
                'max:500',
                'regex:/^(?!.*(?:<script.*?>.*?<\/script>|http:\/\/|https:\/\/|\/\/)).*$/',
            ],
            'role_id' => 'required|exists:roles,id',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'];
            $user->description = $validated['description'];
            $user->role_id = $validated['role_id'];

            if ($request->hasFile('profile_image')) {
                $imagePath = $request->file('profile_image')->store('profile_images', 'public');
                $user->profile_image = $imagePath;
            }

            $user->save();

            return response()->json([
                'message' => 'User created successfully',
                'data' => $user,
            ], 201);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error creating role',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return view('users.index');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'data' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

public function update(Request $request, string $id)
{
    // Validate the incoming data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $id,
        'phone' => 'nullable|string|max:15',
        'description' => 'nullable|string',
        'role_id' => 'required|exists:roles,id',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Find the user by ID
    $user = User::findOrFail($id);

    // Update the user's data
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    $user->phone = $validatedData['phone'];
    $user->description = $validatedData['description'];
    $user->role_id = $validatedData['role_id'];

    // Handle profile image upload if a new image is provided
    if ($request->hasFile('profile_image')) {
        // Delete old image if it exists
        if ($user->profile_image) {
            Storage::delete('public/' . $user->profile_image);
        }

        // Store the new image and save the path
        $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        $user->profile_image = $imagePath;
    }

    // Save the updated user
    $user->save();

    return response()->json([
        'message' => 'User updated successfully',
        'data' => $user
    ], 200);
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = User::findOrFail($id);
        $role->delete();
        return response()->json([
            'message' => 'User deleted successfully',
            'data' => $role,
        ], 201);
    }
}
