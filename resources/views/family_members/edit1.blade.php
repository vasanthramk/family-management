@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Family Member</h2>
    <form action="{{ route('family_members.update', $member->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $member->name }}" required>
        </div>
        <div class="mb-3">
            <label>Birthdate</label>
            <input type="date" name="birthdate" class="form-control" value="{{ $member->birthdate }}" required>
        </div>
        <div class="mb-3">
            <label>Education</label>
            <input type="text" name="education" class="form-control" value="{{ $member->education }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
