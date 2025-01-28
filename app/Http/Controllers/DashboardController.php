<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
    
        $query->where('id', '!=', auth()->id());

        if ($request->has('location') && $request->location !== '') {
            $query->whereHas('profile', function ($query) use ($request) {
                $query->where('location', $request->location);
            });
        }

        if ($request->has('gender') && $request->gender !== '') {
            $query->whereHas('profile', function ($query) use ($request) {
                $query->where('gender', $request->gender);
            });
        }
    
        if ($request->has('bio') && $request->bio !== '') {
            $keywords = explode(' ', trim($request->bio));
            $query->whereHas('profile', function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere('bio', 'like', '%' . trim($keyword) . '%');
                }
            });
        }
    
        $users = $query->with('profile')->get();
    
        foreach ($users as $user) {
            if ($user->profile && $user->profile->birth_date) {
                $user->age = \Carbon\Carbon::parse($user->profile->birth_date)->age;
            } else {
                $user->age = null;
            }
        }
    
        $noFiltersApplied = !($request->has('gender') || $request->has('bio') || $request->has('location'));
    
        return view('dashboard', compact('users', 'noFiltersApplied'));
    }    
}
