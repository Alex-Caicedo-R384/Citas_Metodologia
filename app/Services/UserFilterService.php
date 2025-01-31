<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

class UserFilterService
{
    public function filter(Request $request)
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

        return $query->with('profile')->get();
    }
}
