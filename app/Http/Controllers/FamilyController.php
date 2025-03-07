<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Http\Requests\FamilyRequest;
use App\Models\Family;
use App\Models\FamilyMember;

//class FamilyController extends Controller
class FamilyController extends Controller
{
    public function index()
    {
        $families = Family::withCount('members')->get();  

        //dd($families);
        return view('families.index', compact('families'));
    }

    public function create()
    {
        $response = Http::get("https://api.npoint.io/b6428f19110738a374df"); // Replace with a valid API URL
        $locations = $response->json();
        //dd($locations);
        return view('families.create', compact('locations'));
        
    }

    public function store(FamilyRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('family_photos', 'public');
        }

        Family::create($data);
        return redirect()->route('families.index')->with('success', 'Family added successfully!');
    }

    public function show(Family $family)
    {
        $family->load('members');
        return view('families.show', compact('family'));
    }

    public function profile(Family $family)
    {
        $familyMembers = FamilyMember::where('family_id', $family->id)->get();
        //dd($FamilyMember);
        return view('families.profile', compact('family','familyMembers'));
    }
    
    public function edit($id)
    {
        $family = Family::findOrFail($id); // Retrieve the family by ID
        //return view('families.edit', compact('family'));

        $response = Http::get("https://api.npoint.io/b6428f19110738a374df"); // Replace with your valid API URL
        $locations = $response->json();

        return view('families.edit', compact('family', 'locations'));
    }

    public function update(FamilyRequest $request, Family $family)
    {
        //dd('hi');
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('family_photos', 'public');
        }
        $family->update($data);
        return redirect()->route('families.index')->with('success', 'Family updated successfully!');
    }

    public function destroy(Family $family)
    {
        $family->delete();
        return redirect()->route('families.index')->with('success', 'Family deleted successfully!');
    }
}
