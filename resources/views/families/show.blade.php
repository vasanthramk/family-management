@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Family Details</h2>
    <p><strong>Name:</strong> {{ $family->name }} {{ $family->surname }}</p>
    <p><strong>Mobile:</strong> {{ $family->mobile_no }}</p>
    <p><strong>Address:</strong> {{ $family->address }}</p>

    <h3>Family Members**</h3>
    <a href="#" class="btn btn-primary">Add Member</a>
    <table class="table table-bordered" style="border-collapse:separate;  border:solid black 1px; border-radius:6px;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Birthdate</th>
                <th>Education</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($family->familyMembers as $member)
            <tr>
                <td>{{ $member->name }}</td>
                <td>{{ $member->birthdate }}</td>
                <td>{{ $member->education }}</td>
                <td>
                    <a href="{{ route('family_members.edit', $member->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('family_members.destroy', $member->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
