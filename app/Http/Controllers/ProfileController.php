<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ProfileService;


class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function create()
    {
        return view('profile.create');
    }

    public function show(Request $request)
    {
        return view('profile.show', [
            'user' => $request->user(),
        ]);
    }

    public function edit(Request $request)
    {
        $profile = $request->user()->profile;
        
        return view('profile.edit', compact('profile'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|string',
            'location' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        $this->profileService->createProfile($validated, $request->user()->id); 
        return redirect()->route('profile.show')->with('status', 'Profile created successfully!');
    }

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

        $this->profileService->updateProfile($validated, $request->user()); 
        return redirect()->route('profile.show')->with('status', 'Profile updated successfully!');
    }


    public function destroy(Request $request)
    {
        $this->profileService->deleteProfile($request->user()); // Usar el servicio para eliminar el perfil
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}