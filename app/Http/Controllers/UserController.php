<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return UserCollection
     */
    public function search(Request $request)
    {
        $users = User::search($request->input('query'))
            ->paginate($request->input('pagination', 20));

        return new UserCollection($users);
    }

    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
            ]);

            $user->searchable();

            return response()->json(['message' => 'User created and indexed successfully!', 'user' => $user], 201);

        } catch (ValidationException $e) {

           // Return validation error
            return response()->json(['errors' => $e->errors()], 422);

        } catch (\Exception $e) {

            // Return any other error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($user)
    {

        // Finding user by ID
        $user = User::findOrFail($user);


        // Deleting user from Elasticsearch
        $user->unsearchable();

        // Deleting user from database
        $user->delete();

        return response()->json(['message' => 'User deleted successfully!'], 200);
    }




}

