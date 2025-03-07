@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $family->name }} {{ $family->surname }}</h2>
    <p><strong>Birthdate:</strong>{{ \Carbon\Carbon::parse($family->birthdate)->format('d/m/Y') }}</p>
    <p><strong>Mobile:</strong> {{ $family->mobile_no }}</p>
    <p><strong>Address:</strong> {{ $family->address }}, {{ $family->city }}, {{ $family->state }} - {{ $family->pincode }}</p>
    
    <h3>Family Members</h3>
    <table class="table" style="border-collapse:separate;  border:solid black 1px; border-radius:6px;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Birthdate</th>
                <th>Marital Status</th>
                <th>Weeding Date</th>
                <th>Education</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            
            @if($familyMembers && $familyMembers->count() > 0)
                @foreach($familyMembers as $member)
                <tr>
                    <td>{{ $member->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($member->birthdate)->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($member->marital_status) }}</td>
                    <td>{{ is_null($member->wedding_date) ? '- - - - - -' : \Carbon\Carbon::parse($member->wedding_date)->format('d/m/Y') }}</td>
                    <td>{{ $member->education }}</td>
                    <td>
                        @if($member->photo)
                            <img src="{{ asset('storage/' . $member->photo) }}" width="50" height="50">
                        @else
                            No Photo
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('family_members.edit', $member->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('family_members.destroy', $member->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            @else
                <tr> <td colspan='7'; align='center'>No Family Members</td></tr>
            @endif
        </tbody>
    </table>

    <h3>Add Family Member</h3>
    <form action="{{ route('family_members.store', $family->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                @error('name') <span class="text-danger">{{$message}}</span> @enderror

            </div>
            <div class="col-md-6 mb-3">
                <label>Birthdate</label>
                <input type="date" name="birthdate" value="{{ old('birthdate') }}" class="form-control">
                @error('birthdate') <span class="text-danger">{{$message}}</span> @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Marital Status</label>
                <select name="marital_status" class="form-control" id="maritalStatus">
                    <option value="unmarried" {{ old('marital_status') == 'unmarried' ? 'selected' : '' }} >Unmarried</option>
                    <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>Married</option>
                </select>
                @error('marital_status') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="col-md-6 mb-3" id="weddingDateField" 
            style="display: {{ old('marital_status', $member->marital_status) == 'unmarried' ? 'none' : 'block' }};">
            
                <label>Wedding Date</label>
                <input type="date" name="wedding_date" value="{{ old('wedding_date') }}" class="form-control">
                @error('wedding_date') <span class="text-danger">{{$message}}</span> @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Education</label>
                <input type="text" name="education" value="{{ old('education') }} {{ old('photo') }}" class="form-control">
                @error('education') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Photo</label>
                <input type="file" name="photo" value="{{ old('photo') }}" class="form-control">
                @error('photo') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            
        </div>
        
        <button type="submit" class="btn btn-success"  @if($family->marital_status == "unmarried") disabled @endif>Add Member</button>
    </form>
</div>

<script>
    document.getElementById('maritalStatus').addEventListener('change', function() {
    document.getElementById('weddingDateField').style.display = (this.value === 'married') ? 'block' : 'none';

    window.onload = function() {
        document.getElementById('weddingDateField').style.display = none;
    }

    
});
</script>

@endsection
