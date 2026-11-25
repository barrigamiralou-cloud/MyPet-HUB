<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Pet;
use App\Support\Once;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        // Eager-load every relationship from the User model.
        $user = $request->user()->load([
            'profile',
            'pets' => fn ($q) => $q->latest(),
            'businesses',
        ]);

        return view('dashboard', compact('user'));
    }

    /** hasOne(Profile) */
    public function updateProfile(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name'  => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'bio'        => ['nullable', 'string', 'max:1000'],
        ]);

        // updateOrCreate is safe to repeat: it never makes a second row.
        $request->user()->profile()->updateOrCreate(
            ['user_id' => $request->user()->id],
            $data
        );

        return redirect()->route('dashboard')->with('status', 'Profile saved.');
    }

    /** hasMany(Pet) */
    public function storePet(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
        ]);

        if (! Once::consume($request->input('_once'))) {
            return redirect()->route('dashboard');
        }

        $request->user()->pets()->create($data);

        return redirect()->route('dashboard')->with('status', 'Pet added.');
    }

    public function destroyPet(Request $request, Pet $pet): RedirectResponse
    {
        // Only the owner can delete.
        abort_unless($pet->user_id === $request->user()->id, 403);

        $pet->delete();

        return redirect()->route('dashboard')->with('status', 'Pet removed.');
    }

    /** belongsToMany(Business) with pivot 'active' */
    public function storeBusiness(Request $request): RedirectResponse
    {
        $input = $request->validate([
            'business_name'        => ['required', 'string', 'max:255'],
            'business_description' => ['nullable', 'string', 'max:1000'],
        ]);

        if (! Once::consume($request->input('_once'))) {
            return redirect()->route('dashboard');
        }

        $business = Business::create([
            'name'        => $input['business_name'],
            'description' => $input['business_description'] ?? null,
        ]);
        $request->user()->businesses()->attach($business->id, ['active' => true]);

        return redirect()->route('dashboard')->with('status', 'Business created.');
    }

    public function toggleBusiness(Request $request, Business $business): RedirectResponse
    {
        $current = $request->user()->businesses()->where('business_id', $business->id)->first();

        abort_unless($current, 403);

        $request->user()->businesses()->updateExistingPivot($business->id, [
            'active' => ! $current->pivot->active,
        ]);

        return redirect()->route('dashboard');
    }
}
