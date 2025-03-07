<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
//use App\Http\Requests\FamilyMemberRequest;
use App\Models\Family;
use App\Models\FamilyMember;

/*class FamilyMemberController extends Controller
{
    public function store(FamilyMemberRequest $request, Family $family)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('member_photos', 'public');
        }

        $family->members()->create($data);
        return redirect()->route('families.show', $family)->with('success', 'Family member added successfully!');
    }

    public function update(FamilyMemberRequest $request, FamilyMember $member)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('member_photos', 'public');
        }
        $member->update($data);
        return redirect()->route('families.show', $member->family)->with('success', 'Family member updated successfully!');
    }

    public function destroy(FamilyMember $member)
    {
        $member->delete();
        return redirect()->route('families.show', $member->family)->with('success', 'Family member deleted successfully!');
    }
}*/

class FamilyMemberController extends Controller
{
    public function index(Family $family)
    {
        $familyMembers = FamilyMember::where('family_id', $family->id)->get();
        //dd($FamilyMember);
        return view('family_members.show', compact('family','familyMembers'));
    }

    public function store(Request $request, $familyId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'marital_status' => 'required',
            'wedding_date' => 'required_if:marital_status,married|nullable|date',
            'education' => 'required|string|max:255',
            'photo' => 'required|image|max:2048',
        ]);

        $photoPath = $request->file('photo') ? $request->file('photo')->store('family_members', 'public') : null;

        $family = Family::findOrFail($familyId);

        $family->members()->create([
            'name' => $request->name,
            'birthdate' => $request->birthdate,
            'marital_status' => $request->marital_status,
            'wedding_date' => $request->wedding_date,
            'education' => $request->education,
            'photo' => $photoPath,
        ]);

        return redirect()->route('family_members.show', $familyId)->with('success', 'Family member added successfully.');
    }

    public function edit(FamilyMember $member)
    {
        return view('family_members.edit', compact('member'));
    }

    public function update(Request $request, FamilyMember $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'marital_status' => 'required',
            'wedding_date' => 'required_if:marital_status,married|nullable|date',
            'education' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('family_members', 'public');
            $member->photo = $photoPath;
        }

        $member->update([
            'name' => $request->name,
            'birthdate' => $request->birthdate,
            'marital_status' => $request->marital_status,
            'wedding_date' => $request->marital_status == 'unmarried' ? null : $request->wedding_date,
            'education' => $request->education,
        ]);

        
        return redirect()->route('family_members.show', $member->family_id)->with('success', 'Family member updated successfully.');
    }

    public function destroy(FamilyMember $member)
    {   
        
        $member->delete();
        $family = Family::find($member->family_id);
        //dd($family);
        $familyMembers = FamilyMember::where('family_id', $member->family_id)->get();
        //dd($familyMembers);
        //$family=$member->family_id;
        //return redirect()->route('families.show', $member->family_id, $familyMembers)->with('success', 'Family member deleted successfully.');
        return view('family_members.show', compact('family','familyMembers'));
    }
}
