<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // check user
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json([
                'message' => 'User not found',
            ], 401);
        }
        // check password
        if (! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        // Log the user into the server session securely
        \Illuminate\Support\Facades\Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'message' => 'Login successful',
            'user'    => $user,
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Password updated successfully!',
        ]);
    }
}
