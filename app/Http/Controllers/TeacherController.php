<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    /**
     * Display the teacher's profile and matching status.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $matchesCount = 0;

        if ($user->current_district && $user->desired_district) {
            $matchesCount = User::where('desired_district', $user->current_district)
                ->where('current_district', $user->desired_district)
                ->where('id', '!=', $user->id)
                ->count();
        }

        return Inertia::render('Dashboard', [
            'user' => $user,
            'matchesCount' => $matchesCount,
        ]);
    }

    /**
     * Display the teacher's profile update page.
     */
    public function profile()
    {
        $locationsPath = storage_path('app/up_locations.json');
        $locations = file_exists($locationsPath)
            ? json_decode(file_get_contents($locationsPath), true)
            : [];

        return Inertia::render('Teacher/Profile', [
            'user' => Auth::user(),
            'locations' => $locations,
        ]);
    }

    /**
     * Update the teacher's profile information.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'ehrms_code' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'current_district' => 'required|string|max:255',
            'current_block' => 'required|string|max:255',
            'current_school' => 'required|string|max:255',
            'desired_district' => 'required|string|max:255',
            'desired_block' => 'nullable|string|max:255',
        ]);

        $request->user()->update($validated);

        return back();
    }

    /**
     * Find mutual transfer matches based on districts.
     */
    public function findMatches(Request $request)
    {
        $user = $request->user();

        // Ensure user has filled their preferences
        if (!$user->current_district || !$user->desired_district) {
            return back()->with('error', 'Please update your transfer preferences first.');
        }

        // Logic: Find users who share my district as their desired, 
        // AND have my desired district as their current.
        $matches = User::where('desired_district', $user->current_district)
            ->where('current_district', $user->desired_district)
            ->where('id', '!=', $user->id) // Exclude self
            ->select('id', 'name', 'email', 'phone', 'ehrms_code', 'current_district', 'current_block', 'current_school', 'desired_district', 'desired_block')
            ->get();

        return Inertia::render('Matches', [
            'matches' => $matches,
            'my_current' => $user->current_district,
            'my_desired' => $user->desired_district,
        ]);
    }
}
