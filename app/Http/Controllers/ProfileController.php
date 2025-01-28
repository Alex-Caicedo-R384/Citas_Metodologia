<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return view('profile.show', [
            'user' => $request->user(), // Pasar el usuario autenticado
        ]);
    }    

    /**
     * Show the form for creating a new profile.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('profile.create');
    }

    /**
     * Show the form for editing the user's profile.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $profile = $request->user()->profile;

        return view('profile.edit', compact('profile'));
    }

    /**
     * Store a new profile for the authenticated user.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'gender' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
        ]);
    
        $profile = new Profile($validated);
        $profile->user_id = $request->user()->id;
        $profile->save();
    
        return redirect()->route('profile.show')->with('status', 'Profile created successfully!');
    }
    

    /**
     * Update the authenticated user's profile.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);

        $user = $request->user();
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $user->profile->update([
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'location' => $validated['location'],
            'bio' => $validated['bio'],
        ]);

        return redirect()->route('profile.show')->with('status', 'Profile updated successfully!');
    }

    /**
     * Delete the user's account and associated profile.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        $user->profile()->delete();
        $user->delete();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
